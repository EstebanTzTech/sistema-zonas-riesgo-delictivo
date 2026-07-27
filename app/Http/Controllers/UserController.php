<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importa el modelo User

class UserController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios registrados.
     */
    public function index()
    {
        // Obtiene todos los usuarios de la base de datos
        // Puedes usar ->orderBy('id', 'desc')->get() si prefieres ver los más nuevos primero
        $users = User::all();

        // Pasa los usuarios a la vista
        return view('gestor_usuarios', compact('users'));
    }
}