<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/membresias', [MembresiaController::class, 'index'])->name('membresias.index');
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
    Route::get('/rutinas/{rutina}', [RutinaController::class, 'show'])->name('rutinas.show');
    Route::get('/clases', [ClaseController::class, 'index'])->name('clases.index');

    // --- Solo administradores ---
    Route::middleware('role:admin')->group(function () {
        Route::resource('socios', SocioController::class)->except(['destroy']);
        Route::delete('socios/{socio}', [SocioController::class, 'destroy'])->name('socios.destroy');
        Route::resource('planes', PlanController::class)->except(['show']);
        Route::resource('membresias', MembresiaController::class)->only(['create', 'store', 'destroy']);
        Route::resource('pagos', PagoController::class)->only(['create', 'store', 'destroy']);
    });

    // --- Administradores y entrenadores ---
    Route::middleware('role:admin,entrenador')->group(function () {
        Route::resource('rutinas', RutinaController::class)->except(['index', 'show']);
        Route::resource('rutinas.ejercicios', EjercicioController::class)->only(['store', 'update', 'destroy']);
        Route::resource('clases', ClaseController::class)->except(['index']);
        Route::patch('asistencias/{asistencia}', [AsistenciaController::class, 'cambiarEstado'])->name('asistencias.estado');
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('reportes/pdf', [ReporteController::class, 'exportarPdf'])->name('reportes.pdf');
        Route::get('reportes/pagos.pdf', [ReporteController::class, 'exportarPagosPdf'])->name('reportes.pagos_pdf');
        Route::get('reportes/pagos.csv', [ReporteController::class, 'exportarPagos'])->name('reportes.pagos_csv');
        Route::get('api/socios', [SocioController::class, 'buscarJson'])->name('api.socios');
    });

    // --- Acciones de socios ---
    Route::middleware('role:socio')->group(function () {
        Route::post('clases/{clase}/reservar', [AsistenciaController::class, 'reservar'])->name('clases.reservar');
        Route::delete('clases/{clase}/reservar', [AsistenciaController::class, 'cancelar'])->name('clases.cancelar');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
