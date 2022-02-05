<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleStatus extends Model
{
    use HasFactory;

    const
        ENESPERA = 'En espera',
        ENPREPARACION = 'En preparación',
        PARAENTREGA = 'Esperando delivery',
        ENTREGADO = 'Entregado',
        CANCELADO = 'Cancelado';

}
