<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'client_id','default','clarification'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
