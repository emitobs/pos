<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'telephone', 'address_id'];


    public function orders()
    {
        return $this->hasMany(Sale::class);
    }

    public function getDebtsAttribute()
    {
        return $this->orders()->where('debt', 1)->where('payed', 0)->where('status',"!=",'Cancelado')->get();
    }
    public function defaultAddress()
    {
        return $this->hasOne(Sale::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getDefaultAddressAttribute()
    {
        $return_value = '';
        if ($this->addresses->count() > 0) {
            $return_value = $this->addresses()->where('default', 1)->first()->address;
        }
        return $return_value;
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', 'LIKE', "%$name");
    }
}
