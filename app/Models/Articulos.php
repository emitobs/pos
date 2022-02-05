<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    use HasFactory;
    protected $fillable = ['articulo','IdFamilia','muevestock','codbarra','marca','modelo','StockActual', 'StockMin','MonId','IvaId','PrecioCompra','PrecioVenta','Ganancia','UnidadId','FActualiza','PrvId','editable','PLU','Reglote'];
}
