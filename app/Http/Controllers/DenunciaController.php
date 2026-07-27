<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;
use Illuminate\Support\Facades\Session;

class DenunciaController extends Controller
{
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'edad' => 'required|integer|min:10|max:120',
            'direccion' => 'required',
            'correo' => 'required|email',
            'celular' => 'required',
            'ci' => 'required',
            'foto_carnet_anverso' => 'required|image',
            'foto_carnet_reverso' => 'required|image',
            'foto_rostro' => 'required|image',
            'fecha_delito' => 'required|date',
            'descripcion' => 'required',
            'categoria_delito' => 'required',
            'detalle' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        $anverso = $request->file('foto_carnet_anverso')->store('denuncias', 'public');
        $reverso = $request->file('foto_carnet_reverso')->store('denuncias', 'public');
        $rostro = $request->file('foto_rostro')->store('denuncias', 'public');

        Denuncia::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'edad' => $request->edad,
            'direccion' => $request->direccion,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'ci' => $request->ci,
            'foto_carnet_anverso' => $anverso,
            'foto_carnet_reverso' => $reverso,
            'foto_rostro' => $rostro,
            'fecha_delito' => $request->fecha_delito,
            'descripcion' => $request->descripcion,
            'categoria_delito' => $request->categoria_delito,
            'detalle' => $request->detalle,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ]);

        return back()->with('success', '¡Denuncia enviada correctamente!');
    }

    public function lista(Request $request)
    {
        $query = Denuncia::query();

        // Búsqueda por título
        if ($request->filled('buscar')) {
            $query->where('descripcion', 'LIKE', '%' . $request->buscar . '%');
        }

        // Filtro por categoría de delito
        if ($request->filled('categoria')) {
            $query->where('categoria_delito', $request->categoria);
        }

        // Filtro por fecha de delito
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_delito', $request->fecha);
        }

        // Notificación de nuevos delitos desde la última visita
        $ultimaVisita = session('ultima_visita', now()->subMinutes(30)); // Por defecto 30 min antes
        $nuevosDelitos = Denuncia::where('created_at', '>', $ultimaVisita)->count();
        session([
            'nuevos_delitos' => $nuevosDelitos,
            'ultima_visita' => now()
        ]);

        // Obtener denuncias filtradas
        $denuncias = $query->latest()->get();

        // Obtener categorías únicas para el filtro
        $categorias = Denuncia::select('categoria_delito')->distinct()->pluck('categoria_delito');

        return view('gestor_reportes', compact('denuncias', 'categorias'));
    }
}

