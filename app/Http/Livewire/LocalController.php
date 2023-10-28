<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Denomination;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleStatus;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Exception;

class LocalController extends Component
{
    public
        $total,
        $itemsQuantity,
        $cash,
        $change,
        $selected_Product,
        $clarifications,
        $compositions = [],
        $category_selected,
        $client,
        $address,
        $discount,
        $deliveryTime,
        $saleSelected;


    public function mount(Request $request)
    {
        Cart::clear();
        if ($request->saleId) {
            $sale = Sale::find($request->saleId);
            $this->saleSelected = $sale->id;
            foreach ($sale->details as $product) {
                $productDB = Product::find($product->product_id);
                Cart::add($productDB->id, $productDB->name, $productDB->price, $product->quantity, $productDB->image);
            }
            $this->clarifications = $sale->clarifications;
            $this->client = $sale->client;
            $this->address = $sale->address;
            $this->discount = $sale->discount;
            $this->deliveryTime = $sale->deliveryTime;
            $this->cash = $sale->cash;
            $this->change = $sale->change;
        } else {
            $this->cash = 0;
            $this->discount = 0;
            $this->change = 0;
            $this->compositions = [];
            $this->clarifications = "";
            $this->client = "";
            $this->address = "";
            $this->discount = 0;
            $this->deliveryTime = '';
        }
        $this->category_selected = 2;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {

        $products = [];
        if ($this->category_selected) {
            $products = Product::where('category_id', '=', $this->category_selected)->where('desactivated', 0)->orderBy('name', 'asc')->get();
        } else {
            $products = Product::all()->orderBy('name', 'asc');
        }
        $categoriesProducts = Category::all();

        return view(
            'livewire.local.component',
            [
                'products' => $products,
                'categoriesProducts' => $categoriesProducts,
                'denominations' => Denomination::orderBy('value', 'desc')->get(),
                'cart' => Cart::getContent()->sortBy('name')
            ]
        )->extends('layouts.theme.app')
            ->section('content');
    }

    public function refreshTotal()
    {
        if (!is_numeric($this->discount)) {
            $this->total = Cart::getTotal();
        } else {
            $this->total = Cart::getTotal() - $this->discount;
        }
        $this->change = ($this->cash - $this->total);
    }

    public function ACash($value)
    {
        $this->cash += ($value == 0 ? $this->total : $value);
        $this->change = ($this->cash - $this->total);
    }

    public function ClearChangeCash()
    {
        $this->cash = 0;
        $this->change = 0;
    }
    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'refreshProducts' => 'refreshProducts'
    ];

    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product == null || empty($product)) {
            $this->emit('scan-notfound', 'El producto no está registrado');
        } else {
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Producto agregado');
            $this->emit('modal-hide');
        }
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        $exist == true ? true : false;
    }

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        $title = $exist == true ? 'Cantidad actualizada.' : 'Producto agregado.';

        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity)) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }
        $product = Cart::add($product->id, $product->name, $product->price, $cant, $product->imagen);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);
    }

    public function updateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        $title = $exist == true ? 'Cantidad actualizada.' : 'Producto agregado.';
        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity)) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }

        $this->removeItem($productId);

        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado.');
    }

    public function decreaseQty($productId, $cant = 1)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);
        $newQty = ($item->quantity) - $cant;
        if ($newQty > 0) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);
        }
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad actualizada.');
    }

    public function clearCart()
    {
        Cart::clear();
        $this->cash = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Carrito vacio.');
    }

    public function saveSale()
    {
        $payroll = Payroll::with('sales')->where('isClosed', 0)->first();
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
        if ($this->cash < $this->total) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o  igual al total.');
            return;
        }

        DB::beginTransaction();

        try {
            if ($payroll) {
                $sale = Sale::create([
                    'total' => Cart::getTotal() - $this->discount,
                    'subtotal' => Cart::getTotal(),
                    'items' => $this->itemsQuantity,
                    'cash' => $this->cash,
                    'change' => $this->change,
                    'user_id' => Auth()->user()->id,
                    'clarifications' => $this->clarifications,
                    'status' => SaleStatus::ENESPERA,
                    'client' => $this->client,
                    'address' => $this->address,
                    'payroll_id' => $payroll->id,
                    'discount' => $this->discount,
                    'deliveryTime' => $this->deliveryTime,
                    'dayid' => $payroll->sales->count()
                ]);
                if ($sale) {
                    if ($this->deliveryTime == null) {
                        //Si no decide hora de entrega, automaticamente se le suman 30 minutos a la hora de llegada
                        $deliveryTime = strtotime("+30 minutes", strtotime(date('G:i')));
                        $sale->deliveryTime = date('G:i:s', $deliveryTime);
                        $sale->save();
                    }
                    $items = Cart::getContent();
                    foreach ($items as $item) {
                        SaleDetails::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'product_id' => $item->id,
                            'sale_id' => $sale->id,
                        ]);
                        //update stock
                        $product = Product::find($item->id);
                        $product->stock = $product->stock - $item->quantity;
                        $product->save();
                    }
                }

                DB::commit();

                Cart::clear();
                $this->efectivo = 0;
                $this->change = 0;
                $this->total = Cart::getTotal();
                $this->discount = 0;
                $this->itemsQuantity = Cart::getTotalQuantity();
                $this->resetUI();
                $this->emit('sale-ok', 'Venta registrada con éxito');
                $this->emit('print-ticket', $sale->id);
            } else {
                $this->emit('sale-error', 'No se encuentra planilla abierta.');
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
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
        if ($this->cash < $this->total) {
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
                'total' => Cart::getTotal() - $this->discount,
                'subtotal' => Cart::getTotal(),
                'items' => $this->itemsQuantity,
                'cash' => $this->cash,
                'change' => $this->change,
                'user_id' => Auth()->user()->id,
                'clarifications' => $this->clarifications,
                'status' => SaleStatus::ENESPERA,
                'client' => $this->client,
                'address' => $this->address,
                'discount' => $this->discount,
                'deliveryTime' => $this->deliveryTime
            ]);

            $items = Cart::getContent();
            foreach ($items as $item) {
                SaleDetails::create([
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product_id' => $item->id,
                    'sale_id' => $sale->id,
                ]);
                //update stock
                $product = Product::find($item->id);
                $product->stock = $product->stock - $item->quantity;
                $product->save();
            }
            $sale->payroll->calculateTotal();
            $sale->payroll->save();
            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
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

    public function resetUI()
    {
        $this->cash = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->compositions = [];
        $this->clarifications = "";
        $this->category_selected = 2;
        $this->client = "";
        $this->address = "";
        $this->deliveryTime =   "";
        $this->saleSelected = "";
    }
}
