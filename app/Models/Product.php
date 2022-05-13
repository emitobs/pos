<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'barcode', 'cost', 'price', 'alerts', 'stock', 'image', 'category_id', 'description', 'desactivated', 'unit_sale', 'gain'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unitSale()
    {
        return $this->belongsTo(UnitSale::class, 'unit_sale', 'id');
    }

    public function compositions()
    {
        return $this->belongsToMany(Product::class, 'ingredients', 'final_product', 'composition_product');
    }

    public function finalProducts()
    {
        return $this->belongsToMany(Product::class, 'ingredients', 'composition_product', 'final_product');
    }

    public function saleDetails()
    {
        return $this->belongsToMany(SaleDetails::class);
    }


    public function getImagenAttribute()
    {
        if ($this->image != null) {
            return (file_exists('storage/products/' . $this->image) ? $this->image : 'noimg.png');
        } else {
            return 'noimg.png';
        }
    }

    public function raffles(){
        return $this->belongsToMany(Raffle::class)->using(RaffleProduct::class);
    }
}
