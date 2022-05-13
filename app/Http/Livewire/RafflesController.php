<?php

namespace App\Http\Livewire;

use App\Models\Raffle;
use Livewire\Component;

class RafflesController extends Component
{
    public function render()
    {
        return view('livewire.raffles.raffles-controller')->extends('layouts.theme.app')
        ->section('content');
    }
}
