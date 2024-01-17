<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'subtotal',
        'discount',
        'items',
        'cash',
        'change',
        'status',
        'user_id',
        'clarifications',
        'client_id',
        'address',
        'payroll_id',
        'deliveryTime',
        'deliveredTime',
        'delivery_id',
        'dayid',
        'debt',
        'remaining',
        'rounding',
        'beeper'
    ];

    public function details()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments(){
        return $this->hasMany(Payment_in::class);
    }

}
