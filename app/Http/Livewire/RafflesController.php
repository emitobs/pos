<?php

namespace App\Http\Livewire;

use App\Models\Raffle;
use App\Models\RaffleCode;
use Illuminate\Support\Str;
use Livewire\Component;

class RafflesController extends Component
{

    public function generate_codes()
    {
        for ($i = 1; $i <= $this->qnty_code; $i++) {
            $random_code = $this->generate_unique_code();
            RaffleCode::create([
                'code' => $random_code
            ]);
        }
        $this->set_random_awards();
        $this->emit('generated_codes');
    }

    public function generate_unique_code()
    {
        $random_code = Str::random(10);
        if (RaffleCode::where('code', $random_code)->get()->count() == 0)
            return $random_code;
        else
            return $this->generate_unique_code();
    }

    public function set_random_awards()
    {
        $winning_codes = RaffleCode::orderByRaw("RAND()")->limit($this->qnty_awards)->get();
        foreach ($winning_codes as $code) {
            $code->award = 1;
            $code->save();
        }
    }

    public function render()
    {
        $raffles = Raffle::all();
        return view('livewire.raffles.raffles-controller', ["raffles"=> $raffles])->extends('layouts.theme.app')
        ->section('content');
    }
}
