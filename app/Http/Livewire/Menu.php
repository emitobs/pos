<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use App\Services\CategoryService;

class Menu extends Component
{

    protected $categoryService;
    public function __construct()
    {
        parent::__construct();
        // Laravel automáticamente inyectará el servicio aquí
        $this->categoryService = app(CategoryService::class);
    }
    public $title;
    public function render()
    {
        $categories = $this->categoryService->getCategoriesForTheMenu();
        return view('livewire.menu', ['categories' => $categories])->extends('layouts.theme.app')
            ->section('content');
    }
}
