<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products_Service extends Model
{
    use HasFactory;
    protected $fillable = ['service_id', 'product_name', 'quantity', 'unit_price', 'order_id', 'total','product_id','detail'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function order()
    {
        return $this->belongsTo(OrderService::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
