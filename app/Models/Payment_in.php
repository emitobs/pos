<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_in extends Model
{
    use HasFactory;
    protected $table = "payments_in";
    protected $fillable =  ['amount', 'client_id', 'user_id'];
}
