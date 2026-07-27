<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialDelito extends Model
{
    use HasFactory;

    protected $table = 'historial_delitos';

    protected $fillable = [
        'delito_id',
        'usuario_id',
        'accion',
        'tipo_delito_nombre',
        'descripcion_cambio',
        'fecha_accion',
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function delito()
    {
        return $this->belongsTo(Delito::class, 'delito_id');
    }
}
