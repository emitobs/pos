<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    public $fillable = ['dateClosed', 'totalCash', 'totalSales'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function calculateTotal()
    {
        $this->totalCash = $this->sales->where('status', "!=", SaleStatus::CANCELADO)->sum('total');
        $this->totalSales = Sale::where('payroll_id', $this->id)->where('status', "!=", SaleStatus::CANCELADO)->count();
        $this->save();
    }

    public function getTotalAttribute(){
        return Sale::where('payroll_id', $this->id)->where('status', SaleStatus::ENTREGADO)->where('debt',0)->sum('total');
    }
}
