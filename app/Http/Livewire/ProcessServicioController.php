<?php

namespace App\Http\Livewire;

use App\Models\Service;
use App\Models\Payroll;
use Livewire\Component;
use Illuminate\Http\Request;

class ProcessServicioController extends Component
{

    public $service_to_finish, $payment_method, $cash, $change, $discount, $cart_total, $rounding, $total_result, $total, $itemsQuantity, $payroll, $searched_client, $search, $cart_local, $products_to_pay;
    public function mount(Request $request)
    {
        $service_id = explode('/', $request->path());
        $this->service_to_finish = Service::find($service_id[1]);
    }
    public function render()
    {
        $this->payroll = Payroll::where('isClosed', 0)
            ->where('responsible', auth()->user()->id)
            ->first();

        return view('livewire.processServices.process-servicio-controller')->extends('layouts.theme.app')->section('content');
    }
}
