<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialDelito;

class HistorialDelitoController extends Controller
{
    public function index(Request $request)
    {
        $query = HistorialDelito::with(['usuario', 'delito']);

        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->usuario . '%');
            });
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_accion', $request->fecha);
        }

        $historial = $query->orderBy('fecha_accion', 'desc')->get();

        return view('historialdelitos', compact('historial'));
    }
}
