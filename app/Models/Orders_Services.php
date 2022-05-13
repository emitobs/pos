<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_Services extends Model
{
    protected $fillable = ['service_id', 'product_id','delivery_time'];
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Products_Service::class, 'order_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
