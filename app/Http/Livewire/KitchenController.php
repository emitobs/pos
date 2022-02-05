<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Sale;
use App\Models\SaleStatus;
use Livewire\WithPagination;

class KitchenController extends Component
{

    use WithPagination;

    public $componentName, $pageTitle, $orderStatus, $status_selected, $saleDetails, $sale;

    public function  mount()
    {
        $this->componentName = 'Cocina';
        $this->pageTitle = 'Todos';
        $this->status_selected = 'En espera';
    }

    public function render()
    {
        $orders = [];
        $currentPayroll = Payroll::Where('isClosed', 0)->first();
        if ($currentPayroll) {
            if ($this->status_selected == 'Todos' || $this->status_selected == "") {
                $orders = $currentPayroll->sales()->orderBy('deliveryTime', 'asc')->paginate(7);
            } else {
                $orders  = $currentPayroll->sales()->where('status', $this->status_selected)->orderBy('deliveryTime', 'asc')->paginate(7);
            }
        }
        return view('livewire.kitchen.component', [
            'orders' => $orders,
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function seeDetail($sale)
    {
        $this->sale = Sale::find($sale);
        $this->emit('show-modal', 'Show modal');
    }

    public function inTheKitchen($order)
    {
        $sale = Sale::find($order);
        if ($sale) {
            $sale->status = SaleStatus::ENPREPARACION;
            $sale->save();
            $this->emit('notify', 'Pedido a cocina');
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
}
