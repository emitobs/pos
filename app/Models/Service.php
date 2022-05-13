<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['finished_at', 'table_id', 'attendant'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function products()
    {
        return $this->hasMany(Products_Service::class);
    }

    public function orders(){
        return $this->hasMany(Orders_Services::class);
    }
}
