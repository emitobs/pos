<?php

namespace App\Http\Livewire;

use App\Models\Delivery;
use App\Models\Sale;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;


class DeliveriesController extends Component
{
    use WithPagination;
    public $componentName = 'Deliveries', $selected_id = 0, $disabled = 0, $name, $telephone, $delivery, $selected_delivery, $delivery_daily_orders, $order_to_assign;

    protected $listeners = [
        'assign_order' => 'assign_order'
    ];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $deliveries = Delivery::where('disabled', 0)->paginate(8);
        return view('livewire.deliveries.deliveries', ['deliveries' => $deliveries])->extends('layouts.theme.app')
            ->section('content');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|min:3'
        ];

        $messages = [
            'name.required' => "Nombre necesario",
            'name.min' => "Mínimo necesario de caracteres 3."
        ];

        $this->validate($rules, $messages);

        $new_delivery = Delivery::create([
            'name' => $this->name,
            'telephone' => $this->telephone,
        ]);
        $this->emit('delivery_created');
        $this->resetUI();
    }

    public function Edit(Delivery $delivery)
    {
        if ($delivery) {
            $this->selected_id = $delivery->id;
            $this->name = $delivery->name;
            $this->telephone = $delivery->telephone;
            $this->disabled = $delivery->disabled;
            $this->emit('edit_delivery');
        } else {
            $this->emit('noty', 'No se encuentra delivery');
        }
    }

    public function Update()
    {
        $rules = [
            'name' => 'required|min:3'
        ];

        $messages = [
            'name.required' => "Nombre necesario",
            'name.min' => "Mínimo necesario de caracteres 3."
        ];
        $this->validate($rules, $messages);
        $delivery = Delivery::find($this->selected_id);
        if ($delivery) {
            $delivery->update([
                'name' => $this->name,
                'telephone' => $this->telephone,
                'disabled' => $this->disabled,
            ]);
            if ($delivery->disabled)
                $delivery->delete();
            $this->emit('delivery_updated', 'Delivery actualizado.');
            $this->resetUI();
        }
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->disabled = 0;
        $this->name = '';
        $this->telephone = '';
    }

    public function assign_orders(Delivery $delivery)
    {
        $this->selected_delivery = $delivery;
        $daily_payroll = Payroll::where('isClosed', 0)->first();
        $this->delivery_daily_orders = Sale::where('payroll_id', $daily_payroll->id)->where('delivery_id', $this->selected_delivery->id)->get();
        $this->emit('show_assing_orders');
    }

    public function assign_order()
    {
        $sale = Sale::find($this->order_to_assign);
        if ($sale) {
            $sale->delivery_id = $this->selected_delivery->id;
            $sale->status = 'Entregado';
            $sale->save();
            $this->order_to_assign = '';
            $this->delivery_daily_orders = $this->selected_delivery->daily_orders;
            $this->emit('refresh_daily_deliveries', $this->selected_delivery->daily_orders);
            $this->emit('order_assigned', 'Delivery asignado');
        } else {
            $this->emit('order_not_found', 'No se encontró pedido');
        }
    }
}
