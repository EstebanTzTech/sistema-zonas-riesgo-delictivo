<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistorialDelitoController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/inicio', function () {
    return view('inicio');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';





use App\Http\Controllers\DenunciaController;



Route::get('/denuncia', function () {
    return view('formulario_denuncias');
})->name('denuncia.formulario');

Route::post('/denuncias/guardar', [DenunciaController::class, 'guardar'])->name('denuncia.guardar');
Route::get('/denuncias/lista', [DenunciaController::class, 'lista'])->name('denuncia.lista');


Route::get('/modulo/principal', function () {
    return view('modulo_principal');
})->middleware(['auth', 'verified'])->name('modulo_principal');




use App\Http\Controllers\DelitoController;

Route::get('/mapausuario', [DelitoController::class, 'mapa'])->name('mapa.usuario');
Route::get('/mapa/markers', [DelitoController::class, 'getMarkers'])->name('mapa.markers');
Route::post('/mapa/guardar', [DelitoController::class, 'guardar'])->name('mapa.guardar');

Route::get('/gestor-delitos', [DelitoController::class, 'index'])->name('gestor.delitos');
Route::delete('/gestor-delitos/{id}', [DelitoController::class, 'eliminar'])->name('gestor.eliminar');
Route::get('/gestor-delitos/{id}/editar', [DelitoController::class, 'editar'])->name('gestor.editar');
Route::put('/gestor-delitos/{id}', [DelitoController::class, 'actualizar'])->name('gestor.actualizar');

Route::put('/delitos/{id}', [DelitoController::class, 'actualizar'])->name('delitos.actualizar');


Route::get('/gestor-delitos/{id}/reporte', [DelitoController::class, 'generarReporte'])->name('delitos.reporte');

// Historial de delitos 
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/historial-delitos', [HistorialDelitoController::class, 'index'])->name('historial.delitos');
});


use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::get('/descargar/{archivo}', function ($archivo) {
    $path = storage_path('app/public/denuncias/' . $archivo);

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::download($path);
})->name('descargar.archivo');


use App\Http\Controllers\Auth\RegisteredUserController;
Route::middleware(['auth'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});
// usuarios 

use App\Http\Controllers\UserController; 

Route::middleware(['auth'])->group(function () {
// Ruta para el módulo de visualización de usuarios
    Route::get('/gestor-usuarios', [UserController::class, 'index'])->name('gestor.usuarios');
});