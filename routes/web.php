<?php

use App\Http\Controllers\InsumosController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\StocksController;

use App\Http\Controllers\MovimientosController;

use App\Http\Controllers\UnidadesDeProduccionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/insumos', [InsumosController::class, 'index'])->name('insumos.index');
    Route::get('/insumos/create', [InsumosController::class, 'create'])->name('insumos.create');
    Route::post('/insumos', [InsumosController::class, 'store'])->name('insumos.store');
    Route::get('/insumos/{id}/edit', [InsumosController::class, 'edit'])->name('insumos.edit');
    Route::put('/insumos/{id}', [InsumosController::class, 'update'])->name('insumos.update');
    Route::delete('/insumos/{id}', [InsumosController::class, 'destroy'])->name('insumos.destroy');



    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/create', [StocksController::class, 'create'])->name('stocks.create');
    Route::post('/stocks', [StocksController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/{id}/edit', [StocksController::class, 'edit'])->name('stocks.edit');
    Route::put('/stocks/{id}', [StocksController::class, 'update'])->name('stocks.update');
    Route::delete('/stocks/{id}', [StocksController::class, 'destroy'])->name('stocks.destroy');



    Route::get('/almacenes', [AlmacenesController::class, 'index'])->name('almacenes.index');
    Route::get('/almacenes/create', [AlmacenesController::class, 'create'])->name('almacenes.create');
    Route::post('/almacenes', [AlmacenesController::class, 'store'])->name('almacenes.store');
    Route::get('/almacenes/{id}/edit', [AlmacenesController::class, 'edit'])->name('almacenes.edit');
    Route::put('/almacenes/{id}', [AlmacenesController::class, 'update'])->name('almacenes.update');
    Route::delete('/almacenes/{id}', [AlmacenesController::class, 'destroy'])->name('almacenes.destroy');



    Route::get('/movimientos', [MovimientosController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/create', [MovimientosController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientosController::class, 'store'])->name('movimientos.store');
    Route::get('/movimientos/{id}/edit', [MovimientosController::class, 'edit'])->name('movimientos.edit');
    Route::put('/movimientos/{id}', [MovimientosController::class, 'update'])->name('movimientos.update');
    Route::delete('/movimientos/{id}', [MovimientosController::class, 'destroy'])->name('movimientos.destroy');



    Route::get('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'index'])->name('unidades_de_produccion.index');
    Route::get('/unidades-de-produccion/create', [UnidadesDeProduccionController::class, 'create'])->name('unidades_de_produccion.create');
    Route::post('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'store'])->name('unidades_de_produccion.store');
    Route::get('/unidades-de-produccion/{id}/edit', [UnidadesDeProduccionController::class, 'edit'])->name('unidades_de_produccion.edit');
    Route::put('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'update'])->name('unidades_de_produccion.update');
    Route::delete('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'destroy'])->name('unidades_de_produccion.destroy');

});


Route::middleware(['role:user'])->group(function () {});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
