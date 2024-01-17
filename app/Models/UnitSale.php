<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitSale extends Model
{
    use HasFactory;
    protected $table = "unit_sales";
    protected $filable = ['unit','disabled','isCountable'];
}
