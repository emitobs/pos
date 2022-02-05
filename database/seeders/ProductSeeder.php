<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Pepinillos',
            'cost' => 0,
            'price' => 30,
            'barcode' => '1',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Bacon',
            'cost' => 0,
            'price' => 30,
            'barcode' => '2',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Cebolla común',
            'cost' => 0,
            'price' => 20,
            'barcode' => '3',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Cebolla caramelizada',
            'cost' => 0,
            'price' => 20,
            'barcode' => '4',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Tomate',
            'cost' => 0,
            'price' => 15,
            'barcode' => '5',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Morron asado',
            'cost' => 0,
            'price' => 20,
            'barcode' => '6',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Carne',
            'cost' => 0,
            'price' => 30,
            'barcode' => '7',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Cheddar',
            'cost' => 0,
            'price' => 30,
            'barcode' => '8',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Mozza',
            'cost' => 0,
            'price' => 20,
            'barcode' => '9',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Pollo suprema',
            'cost' => 0,
            'price' => 100,
            'barcode' => '10',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'Cebolla Caramelizada',
            'cost' => 0,
            'price' => 30,
            'barcode' => '11',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
    }
}
