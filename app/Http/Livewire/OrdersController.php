<?php

namespace App\Http\Livewire;

use App\Models\Delivery;
use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleStatus;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\Payroll;
use Illuminate\Http\Request;

class OrdersController extends Component
{
    use WithPagination;

    public
        $componentName,
        $pageTitle,
        $orderStatus,
        $status_selected,
        $saleDetails,
        $sale,
        $deliveries = [],
        $selectedDelivery,
        $selectedPayroll,
        $search;

    protected $listeners = ['deliverySelected' => 'deliverySelected'];


    public function  mount(Request $request)
    {
        $this->selectedPayroll = $request->payroll;
        $this->componentName = 'Pedidos';
        $this->pageTitle = 'Todos';
        $this->status_selected = 'En espera';
        $this->selectedDelivery = 0;
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        $orders = [];
        if ($this->selectedPayroll != null) {
            $currentPayroll = Payroll::find($this->selectedPayroll);
        } else {
            $currentPayroll = Payroll::Where('isClosed', 0)->where('responsible', auth()->user()->id)->first();
        }
        if ($currentPayroll != null) {
            if ($this->status_selected == 'Todos') {
                if (strlen($this->search) > 0) {
                    $orders = $currentPayroll->sales()
                        ->where(function ($query) {
                            $query->where('client', 'like', '%' . $this->search . '%')
                                ->orWhere('address', 'like', '%' . $this->search . '%')
                                ->orWhere('id', 'like', '%' . $this->search . '%');
                        })
                        ->orderBy('deliveryTime', 'asc')->paginate(7);
                } else {
                    $orders = $currentPayroll->sales()
                        ->orderBy('deliveryTime', 'asc')
                        ->paginate(25);
                }
            } else {
                if (strlen($this->search) > 0) {
                    $orders  = $currentPayroll->sales()
                        ->where(function ($query) {
                            $query->where('client', 'like', '%' . $this->search . '%')
                                ->orWhere('address', 'like', '%' . $this->search . '%')
                                ->orWhere('id', 'like', '%' . $this->search . '%');
                        })->where('status', $this->status_selected)
                        ->orderBy('deliveryTime', 'asc')
                        ->paginate(25);
                } else {
                    $orders  = $currentPayroll->sales()
                        ->where('status', $this->status_selected)
                        ->orderBy('deliveryTime', 'asc')
                        ->paginate(25);
                }
            }
        }
        return view('livewire.orders.component', [
            'orders' => $orders,
        ])->extends('layouts.theme.app')
            ->section('content');;
    }

    public function Edit(Sale $order)
    {
        $this->sale = $order;
        $this->emit('editProduct-show');
    }

    public function Update()
    {
    }

    public function seeDetail($sale)
    {
        $this->sale = Sale::find($sale);
        $this->emit('show-modal', 'Show modal');
    }

    public function onHold($order)
    {
        $sale = Sale::find($order);
        if ($sale) {
            $sale->status = SaleStatus::ENESPERA;
            $sale->save();
            $this->emit('notify', 'Pedido en espera.');
        }
    }

    public function inTheKitchen($order)
    {
        $sale = Sale::find($order);
        if ($sale) {
            $sale->status = SaleStatus::ENPREPARACION;
            $sale->save();
            $this->emit('notify', 'Pedido en cocina.');
        }
    }

    public function readyToDeliver($order)
    {
        $sale = Sale::find($order);
        if ($sale) {
            $sale->status = SaleStatus::PARAENTREGA;
            $sale->save();
            $this->emit('notify', 'Pedido pronto para entrega');
        }
    }

    public function selectDelivery($sale)
    {
        $this->sale = Sale::find($sale);
        $this->deliveries = Delivery::all();
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
        $payroll->calculateTotal();
        $this->emit('hide-selectDelivery');
        $this->emit('notify', 'Pedido entregado.');
    }

    public function cancel($order)
    {
        $sale = Sale::find($order);
        if ($sale) {
            $sale->status = SaleStatus::CANCELADO;
            $sale->save();
            foreach ($sale->details as $detail) {
                $product = Product::find($detail->product_id);
                $product->stock = $product->stock + $detail->quantity;
                $product->save();
            }
            $currentPayroll = Payroll::Where('isClosed', 0)->first();
            $currentPayroll->calculateTotal();
            $this->emit('notify', 'Pedido fue cancelado.');
        }
    }

    public function reprint(Sale $order)
    {
        $this->emit('print-ticket', $order->id);
    }
}
