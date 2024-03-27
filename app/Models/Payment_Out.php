<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_Out extends Model
{
    use HasFactory;
    protected $table = "payments_out";

    protected $fillable = ['amount', 'date', 'reason', 'receipt', 'user_id', 'payroll_id'];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
