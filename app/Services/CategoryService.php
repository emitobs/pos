<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getActivatedCategories()
    {
        return Category::where('desactivated', '0')->get();
    }

    public function getCategoriesForTheMenu()
    {
        $categories = Category::where('desactivated', '0')->whereNotNull('menu_position')->get();

        return $categories;
    }
}
