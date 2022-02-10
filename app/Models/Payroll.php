<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    public $fillable = ['dateClosed', 'totalCash', 'totalSales', 'responsible', 'processing_area', 'initialCash', 'zone'];

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

    public function getTotalAttribute()
    {
        return Sale::where('payroll_id', $this->id)->where('status', SaleStatus::ENTREGADO)->where('debt', 0)->sum('total');
    }

    public function getTotalRaisedAttribute()
    {
        return Sale::where('payroll_id', $this->id)->where('status', SaleStatus::ENTREGADO)->where('debt', 0)->sum('total');
    }

    public function getTotalOrdersDeliveredAttribute()
    {
        return Sale::where('payroll_id', $this->id)->where('status', SaleStatus::ENTREGADO)->where('delivery_id', "!=", null)->where('delivery_id', ">", 1)->where('debt', 0)->count();
    }

    public function getTotalDebtsAttribute()
    {
        //return Sale::where('payroll_id', $this->id)->where('debt', 1)->where('payed', 0)->sum('remaining');
        return collect([
            'total_orders' => Sale::where('payroll_id', $this->id)->where('debt', 1)->where('payed', 0)->count(),
            'total_sum_of_sales' => Sale::where('payroll_id', $this->id)->where('debt', 1)->where('payed', 0)->sum('remaining')
        ]);
    }

    public function getPaymentsWithHandyAttribute()
    {
        //return Sale::where('payroll_id', $this->id)->where('paywithhandy', 1)->count();
        return collect([
            'total_orders' => Sale::where('payroll_id', $this->id)->where('paywithhandy', 1)->count(),
            'total_sum_of_sales' => Sale::where('payroll_id', $this->id)->where('paywithhandy', 1)->sum('total')
        ]);
    }

    public function getUndeliveredOrdersAttribute()
    {
        return collect([
            'total_orders' => Sale::where('payroll_id', $this->id)->where('delivery_id', null)->count(),
            'total_sum_of_sales' => Sale::where('payroll_id', $this->id)->where('status', SaleStatus::ENTREGADO)->where('debt', 0)->sum('total')
        ]);
    }
}
