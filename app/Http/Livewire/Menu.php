<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Menu extends Component
{
    public $title;
    public function render()
    {
        $categories = Category::all();
        $products = Product::where('desactivated', 0)->get();
        return view('livewire.menu', ['products' => $products, 'categories' => $categories])->extends('layouts.theme.app')
            ->section('content');
    }
}
