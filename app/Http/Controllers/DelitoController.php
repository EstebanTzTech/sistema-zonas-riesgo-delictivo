<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delito;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HistorialDelito;
use Illuminate\Support\Facades\Auth;

class DelitoController extends Controller
{
    // Mostrar la vista del mapa interactivo
    public function mapa()
    {
        return view('mapausuario');
    }

    // Obtener todos los delitos en formato JSON para el mapa
    public function getMarkers()
    {
        $delitos = Delito::all();
        return response()->json($delitos);
    }

    // Guardar un delito desde el formulario del mapa (CREAR)
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre_zona' => 'required|string',
            'nivel_riesgo' => 'required|string',
            'radio' => 'required|numeric',
            'fuente_informacion' => 'required|string',
            'estado_delito' => 'required|string',
            'tipo_delito' => 'required|string',
            'fecha_hora' => 'required|date',
            'descripcion' => 'nullable|string',
            'latitud_centro' => 'required|numeric',
            'longitud_centro' => 'required|numeric',
        ]);

        $delito = Delito::create($request->all());

        // Registrar acción de CREACIÓN en el historial
        HistorialDelito::create([
            'delito_id' => $delito->id,
            'usuario_id' => Auth::id(),
            'accion' => 'crear',
            'tipo_delito_nombre' => $delito->tipo_delito, // <-- AÑADIDO
            'descripcion_cambio' => 'Creación del delito: "' . $delito->tipo_delito . '"',
            'fecha_accion' => now(),
        ]);

        return response()->json(['mensaje' => 'Delito guardado correctamente']);
    }

    // Mostrar la vista del gestor de delitos con filtros y búsqueda
    public function index(Request $request)
    {
        $query = Delito::query();

        if ($request->filled('buscar')) {
            $query->where('tipo_delito', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('zona')) {
            $query->where('nombre_zona', 'like', '%' . $request->zona . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_delito', $request->tipo);
        }

        if ($request->filled('riesgo')) {
            $query->where('nivel_riesgo', $request->riesgo);
        }

        if ($request->filled('fuente')) {
            $query->where('fuente_informacion', $request->fuente);
        }

        if ($request->filled('estado')) {
            $query->where('estado_delito', $request->estado);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_hora', $request->fecha);
        }

        $delitos = $query->get();

        return view('gestor_delitos', compact('delitos'));
    }

    // Eliminar un delito (ELIMINAR)
    public function eliminar($id)
    {
        $delito = Delito::findOrFail($id);
        
        // Capturamos el nombre del delito ANTES de eliminarlo (CRUCIAL)
        $tipoDelitoNombre = $delito->tipo_delito; 

        // Registrar en historial antes de eliminar
        HistorialDelito::create([
            'delito_id' => $delito->id,
            'usuario_id' => Auth::id(),
            'accion' => 'eliminar',
            'tipo_delito_nombre' => $tipoDelitoNombre, // <-- CORRECTO
            'descripcion_cambio' => 'El delito "' . $tipoDelitoNombre . '" fue eliminado del sistema.',
            'fecha_accion' => now(),
        ]);

        // Luego eliminar el delito
        $delito->delete();

        return redirect()->route('gestor.delitos')->with('success', 'Delito eliminado correctamente.');
    }

    // Mostrar el formulario de edición de un delito
    public function editar($id)
    {
        $delito = Delito::findOrFail($id);
        return view('editar_delito', compact('delito'));
    }

    // Actualizar un delito (EDITAR)
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre_zona' => 'required|string',
            'nivel_riesgo' => 'required|string',
            'radio' => 'required|numeric',
            'fuente_informacion' => 'required|string',
            'estado_delito' => 'required|string',
            'tipo_delito' => 'required|string',
            'fecha_hora' => 'required|date',
            'descripcion' => 'nullable|string',
            'latitud_centro' => 'required|numeric',
            'longitud_centro' => 'required|numeric',
        ]);

        $delito = Delito::findOrFail($id);
        
        // Capturamos el nombre del delito ANTES de la actualización
        $tipoDelitoNombreAnterior = $delito->tipo_delito;

        $delito->update($request->all());

        // Si el nombre del delito cambió, usamos el nuevo nombre para el registro de historial
        $tipoDelitoNombreNuevo = $delito->tipo_delito;
        $descripcionCambio = ($tipoDelitoNombreAnterior !== $tipoDelitoNombreNuevo) 
                             ? 'El tipo de delito cambió de "' . $tipoDelitoNombreAnterior . '" a "' . $tipoDelitoNombreNuevo . '".'
                             : 'El delito "' . $tipoDelitoNombreNuevo . '" fue editado.';

        // Registrar acción en el historial
        HistorialDelito::create([
            'delito_id' => $delito->id,
            'usuario_id' => Auth::id(),
            'accion' => 'editar',
            'tipo_delito_nombre' => $tipoDelitoNombreNuevo, // <-- AÑADIDO
            'descripcion_cambio' => $descripcionCambio . ' por el usuario ' . (Auth::user()->name ?? 'desconocido'),
            'fecha_accion' => now(),
        ]);

        return redirect()->route('gestor.delitos')->with('success', 'Delito actualizado correctamente.');
    }

    // Generar PDF del delito
    public function generarReporte($id)
    {
        $delito = Delito::findOrFail($id);

        $pdf = Pdf::loadView('reportes.delito', compact('delito'));

        return $pdf->stream('reporte_delito_' . $delito->id . '.pdf');
    }
}


