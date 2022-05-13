<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'init_date', 'finish_date', 'finished_date'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->using(RaffleProduct::class);
    }

    public function codes()
    {
        return $this->hasMany(RaffleCode::class);
    }

}
