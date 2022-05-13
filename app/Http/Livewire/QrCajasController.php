<?php

namespace App\Http\Livewire;

use App\Models\Raffle;
use App\Models\RaffleCode;
use Livewire\Component;

class QrCajasController extends Component
{
    public $name, $phone, $code;

    protected $listeners = ['check_code'];

    public function render()
    {
        return view('livewire.qr-cajas-controller')->extends('layouts.qrCajas')
        ->section('content');
    }

    public function check_code(){
        $raffle = RaffleCode::where('code', $this->code)->first();
       if($raffle){
            $this->emit('congratulations',['name'=>$this->name, 'award'=>$raffle->content, 'code'=>$this->code]);
       }else{
           $this->emit('better-luck-next-time',['name'=>$this->name]);
       }
    }
}
