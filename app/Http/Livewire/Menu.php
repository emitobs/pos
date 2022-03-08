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
        $category_foods = Category::where('desactivated', 0)->where('processing_area', 1)->get();
        $category_drinks = Category::where('desactivated', 0)->where('processing_area', 2)->get();
        $categories = Category::all();
        $products = Product::where('desactivated', 0)->get();
        return view('livewire.menu', ['foods' => $category_foods, 'drinks' => $category_drinks])->extends('layouts.theme.app')
            ->section('content');
    }
}
