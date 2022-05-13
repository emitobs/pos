<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $table = "mesas";
    protected $fillable = ['status'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function getCurrentServiceAttribute()
    {
        $service = Service::where('table_id', $this->id)->where('finished_at', null)->first();
        return $service;
    }
}
