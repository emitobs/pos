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

    public function check_code()
    {
        $rules = [
            'name' => 'required|min:4',
            'phone' => 'required|min:8',
            'code' => 'required|max:10|min:10'
        ];
        $messages = [
            'name.required' => 'Se debe ingresar el cliente...',
            'name.min' => 'Tu nombre debe de contener al menos 4 caracteres...',

            'phone.required' => 'Se debe ingresar el telefono...',
            'phone.min' => 'El telefono debe contener al menos 8 digitos.',

            'code.required' => 'Se debe ingresar el codigo...',
            'code.min' => 'El codigo no es lo suficientemente largo',
            'code.max' => 'El codigo es demasiado largo'
        ];
        $this->validate($rules, $messages);

        
        $raffle = RaffleCode::where('code', $this->code)->first();
       
        if ($raffle) {
            $this->emit('congratulations', ['name' => $this->name, 'award' => $raffle->content, 'code' => $this->code]);
        } else {
            $this->emit('better-luck-next-time', ['name' => $this->name]);
        }
    }
}
