<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Category;
use App\Models\Denomination;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleStatus;
use App\Models\Client;
use App\Models\Beeper;
use App\Models\OrderDetail;
use App\Models\UnitSale;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Exception;


class PosController extends Component
{
    public
        $total,
        $itemsQuantity,
        $cash,
        $change,
        $selected_product,
        $clarifications,
        $compositions = [],
        $category_selected,
        $telephone,
        $client,
        $selected_client,
        $address,
        $payinhouse = 0,
        $discount = 0,
        $deliveryTime,
        $saleSelected,
        $payWithHandy = 0,
        $clients = [],
        $searched_client,
        $kg_unit = 'grs',
        $kgs_quantity,
        $units_quantity = 1,
        $quantity = 1,
        $cart_total,
        $debt = 0,
        $payment_method = "cash",
        $rounding = 0.0,
        $total_result = 0.0,
        $search,
        $searched_products = [],
        $cash_to_gr,
        $cart_local = [],
        $beeper,
        $products,
        $categoriesProducts,
        $payroll,
        $detail,
        $selected_id,
        $cart = [],
        $payrollSales,
        $select_product;


    public function mount(Request $request)
    {
        if ($request->saleId) {
            $sale = Sale::find($request->saleId);
            $this->saleSelected = $sale->id;
            foreach ($sale->details as $product) {
                $productDB = Product::find($product->product_id);
                array_push($this->cart_local, [
                    'product_id' => $productDB->id,
                    'product_barcode' => $productDB->barcode,
                    'product_name' => $productDB->name,
                    'product_price' => $productDB->price,
                    'unit' => $productDB->unitSale->unit,
                    'quantity' => $product->quantity,
                    'total' => $product->quantity * $productDB->price,
                    'detail' => $product->detail
                ]);
            }
        }
    }

    public function render()
    {
        //CONSULTA POR PLANILLA ABIERTA PARA EL USUARIO LOGUEADO

        $payroll = Payroll::with('sales')->where('isClosed', 0)
            ->where('responsible', auth()->user()->id)
            ->first();

        if ($payroll) {
            $this->payrollSales = $payroll->sales->where('status', '!=', 'Cancelado');
        } else {
            $this->emit('no-payroll');
        }

        //DEVUELVE TODOS LOS PEDIDOS DEL DIA ORDENADOS DEL ULTIMO AL PRIMERO


        //SI EXISTE LA PLANILLA
        if ($payroll) {
            $units = UnitSale::where('disabled', 0)->get();
            $this->payroll = $payroll;
            if ($payroll->zone == 1) {
                $this->categoriesProducts = Category::all();
            }

            if ($payroll->zone == 2) {
                $this->categoriesProducts = Category::where('processing_area', $payroll->zone)->get();
            }
            $categories = [];
            foreach ($this->categoriesProducts as $categorie) {
                array_push($categories, $categorie->id);
            }

            $products = [];
            if ($this->category_selected) {
                $this->products = Product::where('category_id', '=', $this->category_selected)->where('desactivated', 0)->orderBy('name', 'asc')->get();
            } else {
                $this->category_selected = $this->categoriesProducts->first()->id;
                $this->products = Product::where('category_id', '=', $this->categoriesProducts->first()->id)->orderBy('name', 'asc')->get();
            }

            if (strlen($this->search) > 0) {
                $this->searched_products = Product::where('name', 'LIKE', '%' . $this->search . '%')->whereIn('category_id', $categories)->where('desactivated', 0)->get();
            }
        } else {
            $this->emit('sale-error', 'No se encuentra planilla abierta.');
        }

        if (strlen($this->searched_client) > 0) {
            $this->clients = Client::where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->searched_client . '%')
                    ->orWhere('telephone', 'LIKE', '%' . $this->searched_client . '%');
            })->where('disabled', 0)->get();
        }
        if ($this->discount == '') $this->discount = 0;
        if ($this->cash == '') $this->cash = 0;
        $beepers = Beeper::where('inUse', 0)->get();
        return view(
            'livewire.pos.component',
            [
                'products' => $this->products,
                'categoriesProducts' => $this->categoriesProducts,
                'cart' => Cart::getContent()->sortBy('name'),
                'beepers' => $beepers,
                'sales' => $this->payrollSales,
                'all_products' => Product::where('desactivated', 0)->get()
                //'units' => $units
            ]
        )->extends('layouts.theme.app')
            ->section('content');
    }

    public function selectClient(Client $client)
    {
        if (isset($client)) {
            $this->selected_client = $client;
            $this->client = $client->name;
            $this->address = $client->default_address;
            $this->telephone = $client->telephone;
            $this->searched_client = '';
            $this->emit('noty', 'Cliente seleccionado');
        }
    }

    public function refreshTotal()
    {
        if ($this->discount == '') $this->discount = 0;
        $total = 0.0;
        if (count($this->cart_local) > 0) {
            foreach ($this->cart_local as $item) {
                $total += floatval($item['quantity']) * floatval($item['product_price']);
            }
        }
        $this->cart_total = $total;
        $this->rounding =  round(round($total) - $total, 2);
        $this->total_result = round($this->cart_total + $this->rounding);
        $this->change = round(($this->cash + $this->discount) - $this->total_result) > 0 ? round(($this->cash + $this->discount) - $this->total_result) : 0;
    }

    public function ACash($value)
    {
        $this->cash = ($value == 0 ? $this->total_result : $value);
        $this->change = ($this->cash - $this->total_result);
    }

    public function ClearChangeCash()
    {
        $this->cash = 0;
        $this->change = $this->cash - $this->total_result;
    }
    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'refreshProducts' => 'refreshProducts',
        'selectClient' => 'selectClient',
        'select_product' => 'select_product',
        'add_product',
        'loadSale'
    ];


    public function decreaseQty($product_position, $cant = 1)
    {
        if ($this->cart_local[$product_position]['unit'] == "Kg") {
            unset($this->cart_local[$product_position]);
        } else {
            if ($this->cart_local[$product_position]['quantity'] - $cant > 0) {
                $this->cart_local[$product_position]['quantity'] -= $cant;
            } else {
                unset($this->cart_local[$product_position]);
            }
        }
        $this->total = $this->refreshTotal();
        $this->itemsQuantity = count($this->cart_local);
        $this->emit('scan-ok', 'Cantidad actualizada.');
    }


    public function saveSale()
    {
        $payroll = Payroll::with('sales')->where('isClosed', 0)
            ->where('responsible', auth()->user()->id)
            ->first();
        // $rules = [
        //     'client' => 'required',
        // ];
        // $messages = [
        //     'client.required' => 'Se debe ingresar el cliente',
        // ];
        // $this->validate($rules, $messages);

        if ($this->total_result <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta.');
            return;
        }
        if ($this->cash <= 0 && $this->payment_method == 'cash') {
            $this->emit('sale-error', 'Ingresa el efectivo.');
            return;
        }
        if ($this->cash < $this->total) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o  igual al total.');
            return;
        }

        DB::beginTransaction();

        try {
            if ($payroll) {
                if ($this->payment_method == 'debt') $this->debt = 1;
                if ($this->payment_method == 'card') $this->payWithHandy = 1;
                if (!$this->selected_client) {
                    if ($this->client == null && $this->telephone == null && $this->address == null) {
                        $this->selected_client = Client::find(1);
                        $this->address = $this->selected_client->default_address;
                    } else {
                        $new_client = Client::create([
                            'name' => $this->client,
                            'telephone' => $this->telephone
                        ]);
                        Address::create([
                            'address' => $this->address,
                            'client_id' => $new_client->id,
                            'default' => 1,
                            'clarification' => $this->clarifications
                        ]);
                        $this->selected_client = $new_client;
                    }
                }
                $sale = Sale::create([
                    'total' => $this->total_result,
                    'subtotal' => $this->cart_total + $this->discount,
                    'items' => count($this->cart_local),
                    'cash' => $this->cash,
                    'change' => $this->change,
                    'user_id' => Auth()->user()->id,
                    'clarifications' => $this->clarifications,
                    'status' => SaleStatus::ENESPERA,
                    'client_id' => $this->selected_client->id,
                    'address' => $this->address,
                    'payinhouse' => $this->payinhouse,
                    'payWithHandy' => $this->payWithHandy,
                    'payroll_id' => $payroll->id,
                    'discount' => $this->discount,
                    'deliveryTime' => $this->deliveryTime,
                    'dayid' => $payroll->sales->count(),
                    'debt' => $this->debt,
                    'rounding' => $this->rounding,
                    'beeper' => $this->beeper,
                ]);
                if ($sale) {
                    //si la compra va a cuenta, se setea la deuda en el total - la entrega.
                    if ($sale->debt == 1) {
                        $sale->payed = 0;
                        $sale->remaining = $sale->total - $sale->cash;
                        $sale->save();
                    }
                    if ($this->deliveryTime == null) {
                        //Si no decide hora de entrega, automaticamente se le suman 30 minutos a la hora de llegada
                        $deliveryTime = strtotime("+30 minutes", strtotime(date('G:i')));
                        $sale->deliveryTime = date('G:i:s', $deliveryTime);
                        $sale->save();
                    }
                    $items = $this->cart_local;
                    foreach ($items as $item) {
                        $saledetail = SaleDetails::create([
                            'price' => $item['product_price'],
                            'quantity' => $item['quantity'],
                            'product_id' => $item['product_id'],
                            'sale_id' => $sale['id'],
                            'detail' => $item['detail']
                        ]);
                        if ($saledetail && $item['quantity'] > 0) {
                            $saledetail->price = number_format($item['product_price'] * $item['quantity'], 2);
                            $saledetail->quantity = $item['quantity'];
                            $saledetail->save();
                        };
                        //update stock
                        $product = Product::find($item['product_id']);
                        $product->stock = $product->stock - $item['quantity'];
                        $product->save();
                    }
                    if ($sale->beeper) {
                        $beeper = Beeper::find($sale->beeper);
                        $beeper->inUse = 1;
                        $beeper->save();
                    }
                    if ($payroll->zone == 2) {
                        $sale->status = "Entregado";
                        $sale->delivery_id = 1;
                        $sale->save();
                    }
                }
                DB::commit();
                $this->resetUI();
                $this->emit('sale-ok', 'Venta registrada con éxito');
                $this->emit('print-ticket', $sale->id);
            } else {
                $this->emit('sale-error', 'No se encuentra planilla abierta.');
            }
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function updateSale()
    {
        $rules = [
            'client' => 'required',
            'address' => 'required'
        ];

        $messages = [
            'client.required' => 'Se debe ingresar el cliente',
            'address.required' => 'Se necesita dirección.',

        ];

        $this->validate($rules, $messages);

        if ($this->cart_total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta.');
            return;
        }
        if ($this->cash <= 0) {
            $this->emit('sale-error', 'Ingresa el efectivo.');
            return;
        }
        if ($this->cash < $this->cart_total) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o  igual al total.');
            return;
        }

        try {
            $sale = Sale::find($this->saleSelected);
            foreach ($sale->details as $detail) {
                $product = Product::find($detail->product_id);
                $product->stock = $product->stock + $detail->quantity;
                $product->save();
                $saleDetail = SaleDetails::find($detail->id);
                $saleDetail->delete();
            }

            $sale->update([
                'total' => $this->cart_total - $this->discount,
                'subtotal' => $this->cart_total,
                'items' => count($this->cart_local),
                'cash' => $this->cash,
                'change' => $this->change,
                'user_id' => Auth()->user()->id,
                'clarifications' => $this->clarifications,
                'status' => SaleStatus::ENESPERA,
                'client' => $this->client,
                'address' => $this->address,
                'payinhouse' => $this->payinhouse,
                'discount' => $this->discount,
                'deliveryTime' => $this->deliveryTime,
                'payWithHandy' => $this->payWithHandy
            ]);

            $items = $this->cart_local;
            foreach ($items as $item) {
                $xItem = (object) $item;
                SaleDetails::create([
                    'price' => $xItem->product_price,
                    'quantity' => $xItem->quantity,
                    'product_id' => $xItem->product_id,
                    'sale_id' => $sale->id,
                ]);
                //update stock
                $product = Product::find($xItem->product_id);
                $product->stock = $product->stock - $xItem->quantity;
                $product->save();
            }
            $sale->payroll->calculateTotal();
            $sale->payroll->save();
            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = $this->refreshTotal();
            $this->discount = 0;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->deliveryTime = '';
            $this->resetUI();
            $this->emit('sale-ok', 'Pedido editado con éxito');
            $this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
            dd($e);
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::to("print:://$sale->id");
    }

    public function seeProduct($id)
    {
        $product = Product::with('compositions')->find($id);
        $this->sProductName = $product->name;
        $this->sProductDescription = $product->name;
        $this->sProductBarCode = $product->barcode;
        $this->compositions = $product->compositions()->get();
        $this->sProductImage = $product->image;
        $this->selected_Product = $product;
        $this->emit('show-modal', 'show modal');
    }

    public function select_product()
    {
        $this->emit('product_selected');
    }

    public function loadSale(Sale $sale)
    {
        $this->cart_local = [];
        $selected_client = $sale->client;
        $this->telephone = $selected_client->telephone;
        $this->clarifications = $sale->clarifications;
        $this->client = $selected_client->name;
        $this->address = $sale->address;
        $this->deliveryTime = $sale->deliveryTime;
        $this->cash = $sale->cash;
        $this->change = $sale->change;
        $this->saleSelected = $sale->id;
        foreach ($sale->details as $product) {
            $productDB = Product::find($product->product_id);
            array_push($this->cart_local, [
                'product_id' => $productDB->id,
                'product_barcode' => $productDB->barcode,
                'product_name' => $productDB->name,
                'product_price' => $productDB->price,
                'unit' => $productDB->unitSale->unit,
                'quantity' => $product->quantity,
                'total' => $product->quantity * $productDB->price,
                'detail' => $product->detail
            ]);
        }
        $this->refreshTotal();
    }

    public function add_product($barcode)
    {
        $product = Product::where('barcode', $barcode)->firstOrFail();
        if ($product && $product->stock >= $this->quantity) {
            array_push($this->cart, [
                'product_id' => $product->id,
                'quantity' => $this->quantity,
                'detail' => $this->detail
            ]);
        } else {
            dd('que pinta pa');
        }
    }

    public function ScanCode()
    {
        $count = 0;
        $product = Product::where('barcode', $this->select_product)->firstOrFail();
        if ($product) {
            $founded = false;
            while (!$founded && $count < count($this->cart_local)) {
                if ($this->cart_local[$count]['product_barcode'] == $product->barcode) {
                    $founded = true;
                    if ($this->cart_local[$count]['unit'] == "Kg" || $this->cart_local[$count]['detail'] != $this->detail) {
                        array_push($this->cart_local, [
                            'product_id' => $product->id,
                            'product_barcode' => $product->barcode,
                            'product_name' => $product->name,
                            'product_price' => $product->price,
                            'unit' => $product->unitSale->unit,
                            'quantity' => $this->quantity,
                            'total' => $this->quantity * $product->price,
                            'detail' => $this->detail
                        ]);
                        $this->refreshTotal();
                        $this->emit('scan-ok', 'Producto agregado');
                        $this->selected_product = null;
                        $this->select_product = 'default';
                        $this->detail = '';
                        $this->quantity = 1;
                    } else {
                        $this->cart_local[$count]['quantity'] += $this->quantity;
                        $this->cart_local[$count]['total'] = $this->cart_local[$count]['quantity'] * $this->cart_local[$count]['product_price'];
                        $this->refreshTotal();
                        $this->emit('scan-ok', 'Producto agregado');
                        $this->selected_product = null;
                        $this->select_product = 'default';
                        $this->detail = '';
                        $this->quantity = 1;
                    }
                } else {
                    $count++;
                }
            }
            if (!$founded) {
                array_push($this->cart_local, [
                    'product_id' => $product->id,
                    'product_barcode' => $product->barcode,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'unit' => $product->unitSale->unit,
                    'quantity' => $this->quantity,
                    'detail' => $this->detail
                ]);
                $this->refreshTotal();
                $this->emit('scan-ok', 'Producto agregado');
                $this->selected_product = null;
                $this->select_product = 'default';
                $this->detail = '';
                $this->quantity = 1;
            }
        } else {
            $this->emit('scan-notfound', 'El producto no está registrado');
        }
        $this->kgs_quantity = 0;
    }

    public function resetUI()
    {
        $this->cash = 0;
        $this->change = 0;
        $this->total = 0;
        $this->compositions = [];
        $this->clarifications = "";
        $this->client = "";
        $this->address = "";
        $this->payinhouse = 0;
        $this->deliveryTime =   "";
        $this->saleSelected = "";
        $this->payWithHandy = 0;
        $this->debt = 0;
        $this->cart_total = 0;
        $this->total_result = 0;
        $this->rounding = 0;
        $this->units_quantity = 1;
        $this->kgs_quantity = 0;
        $this->cart_local = [];
        $this->selected_client = null;
    }
}
