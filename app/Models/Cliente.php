<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "cliente";
    protected $fillable = ['Rut', 'CI', 'Nombre', 'RSocial', 'Direccion', 'Localidad', 'Telefono', 'Mail', 'Notas', 'Limite', 'ListaP', 'CFinal', 'Celular'];
}
