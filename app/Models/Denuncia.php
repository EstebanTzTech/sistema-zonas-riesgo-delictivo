<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'edad',
        'direccion',
        'correo',
        'celular',
        'ci',
        'foto_carnet_anverso',
        'foto_carnet_reverso',
        'foto_rostro',
        'fecha_delito',
        'descripcion',
        'categoria_delito',
        'detalle',
        'latitud',
        'longitud',
    ];
}
