<?php

namespace App\Http\Livewire;

use App\Models\Beeper;
use Livewire\Component;

class BeepersController extends Component
{
    public function render()
    {
        $beepers = Beeper::all();
        return view('livewire.beepers.beepers', ['beepers' => $beepers])->extends('layouts.theme.app')
            ->section('content');
    }

    public function newBeeper()
    {
        Beeper::create([]);
    }
}
