<?php

namespace App\Http\Livewire;

use App\Models\Payroll;
use App\Models\Sale;
use App\Models\Beeper;
use Livewire\Component;

class Beepersperson extends Component
{

    public $sale;

    public function render()
    {
        $payrolls = Payroll::where('isClosed', 0)->where('zone', 1)->get();
        return view('livewire.beepersperson', ["data" => $payrolls])->extends('layouts.theme.app')
            ->section('content');
    }

    public function seeOrder(Sale $sale){
        $this->sale = $sale;
        $this->emit('show-modal');
    }
    public function deliver_order(Sale $sale){
        $sale->status = "Entregado";
        $sale->delivery_id = 1;
        $sale->save();
        if($sale->beeper){
            if($sale->beeper > 0){
                $beeper = Beeper::find($sale->beeper);
                if($beeper){
                    $beeper->inUse = 0;
                    $beeper->save();
                }
            }
        }
        $this->emit('order_delivered');
    }
}
