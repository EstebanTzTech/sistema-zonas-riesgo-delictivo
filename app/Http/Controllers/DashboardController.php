<?php

namespace App\Http\Controllers;

use App\Models\Delito;
use App\Models\Denuncia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDelitos = Delito::count();
        $totalReportes = Denuncia::count();
        
        // Si quieres: contar solo los delitos pendientes
        $delitosPendientes = Delito::where('estado_delito', 'pendiente')->count(); // solo si tienes ese campo

        return view('dashboard', compact('totalDelitos', 'totalReportes', 'delitosPendientes'));
    }
}
