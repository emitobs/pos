<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Category;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleStatus;
use App\Models\Client;
use App\Models\Beeper;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment_in;
use App\Models\PaymentMethod;
use App\Models\UnitSale;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Exception;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PosController extends Component
{
    protected $cartService, $orderService;

    public
        $pageTitle,
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
        $discount = 0,
        $deliveryTime,
        $saleSelected,
        $clients = [],
        $searched_client,
        $kg_unit = 'grs',
        $kgs_quantity,
        $units_quantity = 1,
        $quantity = 1,
        $cart_total,
        $debt = 0,
        $payment_method = 1,
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
        $select_product,
        $order_payments = ["Efectivo"],
        $payment_method_selected = 1,
        $amount,
        $payments = [],
        $payments_to_delete = [],
        $payments_total = 0,
        $payment_methods,
        $details_to_delete = [],
        $total_items,
        $sale,
        $deliveries,
        $selectedDelivery;



    public function __construct()
    {
        parent::__construct();

        // Laravel automáticamente inyectará el servicio aquí
        $this->cartService = app(CartService::class);
        $this->orderService = app(OrderService::class);
    }

    public function mount(Request $request)
    {
        if ($request->saleId) {
            $sale = Sale::find($request->saleId);
            if ($sale) {
                $this->loadSale($sale);
            } else {
                return redirect('/nuevopedido');
            }
        }
    }

    public function render()
    {
        getNavbarColor();
        //CONSULTA POR PLANILLA ABIERTA PARA EL USUARIO LOGUEADO
        $payroll = Payroll::with('sales')->where('isClosed', 0)
            ->where('responsible', auth()->user()->id)
            ->first();
        if ($payroll) {
            $this->payrollSales = $payroll->sales->where('status', '!=', 'Cancelado')->where('status', '!=', 'Entregado');
        } else {
            $this->emit('no-payroll');
        }

        //DEVUELVE TODOS LOS PEDIDOS DEL DIA ORDENADOS DEL ULTIMO AL PRIMERO


        //SI EXISTE LA PLANILLA
        if ($payroll) {
            $this->payment_methods = PaymentMethod::where('disabled', 0)->get();
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
        if ($this->discount == '') $this->discount = 0;
        if ($this->cash == '') $this->cash = 0;
        $beepers = Beeper::where('inUse', 0)->get();
        $this->cart_total = $this->cartService->getTotal($this->cart_local);
        $this->total_items = $this->cartService->getItemsQuantity($this->cart_local);
        $this->refreshTotal();
        return view(
            'livewire.pos.component',
            [
                'beepers' => $beepers,
                'sales' => $this->payrollSales,
                'payment_methods' => $this->payment_methods,
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
        //calcula el redondeo
        $this->total_result = $this->cart_total - $this->discount;
        $this->rounding =  round(round($this->total_result) - $this->total_result, 2);
        if ($this->rounding != 0.00) {
            $this->total_result = $this->total_result + $this->rounding;
        }
        if ($this->cash > 0) {
            $this->change = $this->cash - $this->total_result;
        } else {
            $this->change = 0;
        }
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
        'loadSale',
        'refreshPos',
        'updateOrderStatus',
        'selectDeliveryToOrder'
    ];

    public function increaseQuantity($position, $quantity, $product)
    {
        try {

            $this->cart_local = $this->cartService->increaseQty($this->cart_local, $position, $product, $this->cart_local[$position]['quantity'] += $quantity);
            session()->flash('message', 'Product quantity increased successfully!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function decreaseQuantity($position, $quantity, $product)
    {
        try {
            $this->cart_local = $this->cartService->decreaseQty($this->cart_local, $position, $product, $this->cart_local[$position]['quantity'] -= $quantity);
            session()->flash('message', 'Product quantity decreased successfully!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function remove_from_cart($position)
    {
        $this->cart_local = $this->cartService->remove_from_cart($this->cart_local, $position);
    }
    public function saveSale()
    {
        if (!$this->isValidForSaving()) return;

        try {
            DB::beginTransaction();
            $this->handleClientCreation();
            $sale = $this->createSale();
            $this->handleSaleDetails($sale);
            $this->handlePayments($sale);
            if ($sale->debt) {
                $this->handleDebt($sale);
            }
            DB::commit();
            $this->resetUI();
            $this->emit('sale-ok', 'Venta registrada con éxito');
            $this->emit('confirm-print-ticket', ['saleId' => $sale->id]);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function updateSale()
    {
        $payroll = Payroll::where('isClosed', 0)->where('responsible', auth()->user()->id)->first();
        // Comienza la transacción de la base de datos.
        DB::beginTransaction();

        try {
            // Se busca la venta que se va a actualizar.
            $sale = Sale::findOrFail($this->saleSelected);

            // Verifica que la venta tenga al menos un producto.
            if ($this->cart_total <= 0) {
                $this->emit('sale-error', 'Agrega productos a la venta.');
                return;
            }
            //Se eliminan los pagos desdeados
            if (isset($this->payments_to_delete) && count($this->payments_to_delete) > 0) {
                foreach ($this->payments_to_delete as $payment_to_delete_id) {
                    $payment_to_delete = Payment_in::findOrFail($payment_to_delete_id);
                    if ($payment_to_delete && $payment_to_delete->sale_id == $this->saleSelected) {
                        $payment_to_delete->delete();
                    } else {
                        throw new Exception("Se intentó borar un pago que no existe.");
                    }
                }
            }

            // Aquí se revierten las cantidades de los productos en el stock y se borran los detalles de la venta.
            foreach ($sale->details as $detail) {
                $product = Product::find($detail->product_id);
                $product->stock += $detail->quantity;
                $product->save();
                $detail->delete();
            }

            // Aquí se actualizan los datos de la venta.
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
                'discount' => $this->discount,
                'deliveryTime' => $this->deliveryTime,
            ]);

            // Aquí se agregan los nuevos detalles de la venta y se actualiza el stock del producto.
            $this->handleSaleDetails($sale);
            $this->handlePayments($sale);
            DB::commit();

            // Aquí se resetean algunos valores a su estado inicial y se limpia el carrito.
            $this->change = 0;
            $this->refreshTotal();
            $this->discount = 0;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->deliveryTime = '';
            $this->resetUI();

            // Al final se emite una notificación de que la venta fue editada con éxito y se emite el evento para imprimir el ticket.
            $this->emit('sale-ok', 'Pedido editado con éxito');
            $this->emit('confirm-print-ticket', ['saleId' => $sale->id]);
        } catch (Exception $e) {
            // Si ocurre un error, se revierte la transacción y se emite un mensaje de error.
            DB::rollback();
            dd($e);
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function deletePayments()
    {
    }

    private function createSale()
    {
        $saleData = [
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
            'payroll_id' => $this->getOpenPayroll()->id,
            'discount' => $this->discount,
            'deliveryTime' => $this->deliveryTime,
            'dayid' => $this->getOpenPayroll()->sales->count() + 1,
            'debt' => $this->debt,
            'rounding' => $this->rounding,
            'beeper' => $this->beeper,
        ];
        $sale = Sale::create($saleData);

        if (!$sale) {
            throw new Exception('No se pudo crear la venta.');
        }
        if (!$this->deliveryTime) {
            $deliveryTime = strtotime("+30 minutes", strtotime(date('G:i')));
            $sale->update(['deliveryTime' => date('G:i:s', $deliveryTime)]);
        }

        return $sale;
    }

    private function handleClientCreation()
    {
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
    }
    private function handlePayments($sale)
    {
        if (count($this->payments) > 0) {
            foreach ($this->payments as $payment) {
                if (!isset($array['id'])) {
                    Payment_in::create([
                        'payment_method_id' => $payment['method_id'],
                        'amount' => $payment['amount'],
                        'sale_id' => $sale->id,
                        'user_id' => Auth()->user()->id,
                        'payroll_id' => $this->payroll->id,
                    ]);
                }
            }
        }

        if (count($this->payments_to_delete) > 0) {
            foreach ($this->payments_to_delete as $payment) {
                Payment_in::destroy($payment);
            }
        }
    }

    private function handleDebt($sale)
    {
        $sale->payed = 0;
        $sale->remaining = $sale->total - $sale->payments->sum('amount');
        $sale->save();
    }

    private function handleSaleDetails($sale)
    {
        foreach ($this->cart_local as $item) {
            $saledetail = SaleDetails::create([
                'price' => $item['product_price'] * $item['quantity'],
                'quantity' => $item['quantity'],
                'product_id' => $item['product_id'],
                'sale_id' => $sale->id,
                'detail' => $item['detail']
            ]);

            if ($saledetail && $item['quantity'] > 0) {
                $saledetail->price = number_format($item['product_price'] * $item['quantity'], 2);
                $saledetail->quantity = $item['quantity'];
                $saledetail->save();
            }

            $product = Product::find($item['product_id']);
            $product->stock = $product->stock - $item['quantity'];
            $product->save();
        }
    }
    private function handleBeeper($sale)
    {
        if ($sale->beeper) {
            Beeper::find($sale->beeper)->update(['inUse' => 1]);
        }
    }
    private function isValidForSaving(): bool
    {
        if (!$this->getOpenPayroll()) {
            $this->emit('sale-error', 'No se encuentra planilla abierta.');
            return false;
        }

        if ($this->total_result <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta.');
            return false;
        }

        $this->getTotalPayments();
        if ($this->total > $this->payments_total && !$this->debt) {
            $this->emit('sale-error', 'El pago debe ser mayor o igual al total.');
            return false;
        }

        return true;
    }

    private function getOpenPayroll()
    {
        return Payroll::with('sales')
            ->where('isClosed', 0)
            ->where('responsible', auth()->user()->id)
            ->first();
    }

    public function select_product()
    {
        $this->emit('product_selected');
    }

    public function loadSale(Sale $sale)
    {
        $this->cartService->resetCart();
        $this->setupSale($sale);
        $this->populateCartWithSaleDetails($sale->details);
        $this->populatePaymentsWithSalePayments($sale->payments);
        $this->refreshTotal();
    }

    private function setupSale(Sale $sale)
    {
        $this->cart_local = [];
        $this->selectClient($sale->client);
        $this->deliveryTime = $sale->deliveryTime;
        $this->cash = $sale->cash;
        $this->change = $sale->change;
        $this->saleSelected = $sale->id;
        $this->debt = $sale->debt;
    }

    private function populateCartWithSaleDetails($details)
    {
        foreach ($details as $productDetail) {
            $product = Product::find($productDetail->product_id);
            $this->addToCart($product, $productDetail->quantity, $productDetail->detail);
        }
    }

    private function populatePaymentsWithSalePayments($payments)
    {
        $this->payments = [];
        if ($payments) {
            foreach ($payments as $payment) {
                $this->payments[] = ['id' => $payment->id, 'method_id' => $payment->payment_method_id, 'amount' => $payment->amount];
            }
            $this->getTotalPayments();
        }
    }

    public function ScanCode()
    {
        try {
            $product = Product::where('barcode', $this->select_product)->firstOrFail();
            $detail = $this->detail;

            if ($detail === null) {
                $detail = ''; // Asignar un valor predeterminado si $detail es null
            }

            $this->addToCart($product, $this->quantity, $detail);
            $this->emit('scan-ok', 'Producto agregado');
            $this->resetSelectedProductInfo();
        } catch (ModelNotFoundException $e) {
            $this->emit('scan-notfound', 'El producto no está registrado');
        }
    }

    private function addToCart(Product $product, int $quantity, ?string $detail)
    {
        $detail = $detail ?? ''; // Asignar un valor predeterminado si $detail es null

        $this->cart_local = $this->cartService->addProduct($this->cart_local, $product, $quantity, $detail);
    }

    public function resetUI()
    {
        $this->cash = 0;
        $this->change = 0;
        $this->total = 0;
        $this->discount = 0;
        $this->compositions = [];
        $this->clarifications = "";
        $this->client = "";
        $this->telephone = "";
        $this->address = "";
        $this->deliveryTime =   "";
        $this->saleSelected = "";
        $this->debt = 0;
        $this->cart_total = 0;
        $this->total_result = 0;
        $this->rounding = 0;
        $this->units_quantity = 1;
        $this->kgs_quantity = 0;
        $this->cart_local = [];
        $this->selected_client = null;
        $this->payments = [];
        $this->payments_to_delete = [];
    }

    public function resetSelectedProductInfo()
    {
        $this->selected_product = null;
        $this->select_product = null;
        $this->detail = '';
        $this->quantity = 1;
    }

    public function addPay()
    {
        $rules = [
            'amount' => 'numeric|min:1',

        ];
        $messages = [
            'amount.numeric' => 'Ingrese un valor numerico.',
            'amount.min' => 'Ingrese un valor minimo de 1',
        ];
        $this->validate($rules, $messages);
        $totalPayments = 0;

        $this->payments[] = ["amount" => $this->amount, "method_id" => $this->payment_method_selected];
        foreach ($this->payments as $pay) {
            $totalPayments += $pay['amount'];
        };

        if ($totalPayments >= $this->cart_total) {
            $this->getTotalPayments();
            $this->emit('aggregate-total-payment');
        } else {
            $this->emit('aggregate-partial-payment');
        }
    }

    public function deletePay($payment_index, $payment_id = null)
    {
        if ($payment_id && !in_array($payment_id, $this->payments_to_delete)) {
            $this->payments_to_delete[] = $payment_id;
        }
        unset($this->payments[$payment_index]);
        $this->getTotalPayments();
    }

    public function getTotalPayments()
    {
        $total = 0;
        foreach ($this->payments as $payment) {
            $total += $payment['amount'];
        }
        $this->payments_total = $total;
        return $total;
    }

    public function updateOrderStatus(Sale $order, string $status)
    {
        if ($this->orderService->change_status($order->id, $status)) {
            $this->emit('order-status-updated');
        } else {
            $this->emit('error', 'No se puedo actualizar el estado');
        }
    }

    public function selectDeliveryToOrder(Sale $order)
    {
        $this->deliveries = Delivery::where('disabled', 0)->get();
        $this->sale = $order;
        $this->emit('show-selectDelivery');
    }

    public function delivered()
    {
        $payroll = Payroll::where('isClosed', 0)->first();
        $sale = Sale::find($this->sale->id);

        if ($sale) {
            $sale->status = SaleStatus::ENTREGADO;
            $sale->deliveredTime = date("G:i");
            $sale->delivery_id = $this->selectedDelivery;
            $sale->save();
        }
        $this->emit('hide-selectDelivery');
        $this->emit('notify', 'Pedido entregado.');
    }
}
