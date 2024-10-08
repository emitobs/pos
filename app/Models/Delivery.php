<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'telephone', 'disabled'];

    use SoftDeletes;
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getDailyOrdersAttribute()
    {
        $daily_payroll = Payroll::where('isClosed', 0)->first();
        if ($daily_payroll) {
            return Sale::where('payroll_id', '=', $daily_payroll->id)->where('delivery_id', $this->id)->get();
        }
    }

    public function payments_in(){
        return $this->hasMany(Payment_in::class);
    }
}
