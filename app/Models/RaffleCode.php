<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleCode extends Model
{
    use HasFactory;
    protected $fillable = ['raffle_id', 'award', 'printed_at', 'used_at','code'];

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}
