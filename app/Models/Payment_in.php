<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_in extends Model
{
    use HasFactory;
    protected $table = "payments_in";
    protected $fillable =  ['amount', 'client_id', 'user_id', 'sale_id', 'payment_method_id', 'delivery_id'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function receiver()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public static function createOrUpdate($data, $id)
    {
        dd($data, $id);
    }
}
