<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;

class PaymentsMethodsController extends Component
{
    public $componentName = 'Métodos de pagos', $selected_id = null, $disabled = false, $name;
    public function render()
    {
        $payments_methods = PaymentMethod::where('disabled', 0)->get();

        return view('livewire.payment_methods.payments-methods', ['payments_methods' => $payments_methods])->extends('layouts.theme.app')
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

        $new_payment_method = PaymentMethod::create([
            'name' => $this->name,
            'disabled' => $this->disabled,
        ]);
        $this->emit('payment_method_created');
        $this->resetUI();
    }

    public function Edit(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod) {
            $this->selected_id = $paymentMethod->id;
            $this->name = $paymentMethod->name;
            $this->disabled = $paymentMethod->disabled;
            $this->emit('edit_paymentMethod');
        } else {
            $this->emit('noty', 'No se encuentra método de pago');
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

        $paymentMethod = PaymentMethod::find($this->selected_id);

        if ($paymentMethod) {
            $paymentMethod->update([
                'name' => $this->name,
                'disabled' => $this->disabled,
            ]);
            $this->emit('paymentMethod_updated', 'Delivery actualizado.');
        }
    }
}
