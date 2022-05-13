<?php

namespace App\Http\Livewire;

use App\Models\Raffle;
use Livewire\Component;

class RafflesController extends Component
{
    public function render()
    {
        $raffles = Raffle::all();
        return view('livewire.raffles.raffles-controller', ["raffles"=> $raffles])->extends('layouts.theme.app')
        ->section('content');
    }
}
