<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delito extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_zona',
        'nivel_riesgo',
        'radio',
        'fuente_informacion',
        'estado_delito',
        'tipo_delito',
        'fecha_hora',
        'descripcion',
        'latitud_centro',
        'longitud_centro'
    ];
}

