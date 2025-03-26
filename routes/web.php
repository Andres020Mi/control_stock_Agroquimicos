<?php

use App\Http\Controllers\InsumosController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ProveedoresController;
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


    Route::get('users', [UserController::class, 'index'])->name('users.index'); // Listar usuarios
    Route::get('users/create', [UserController::class, 'create'])->name('users.create'); // Formulario de creación
    Route::post('users', [UserController::class, 'store'])->name('users.store'); // Guardar usuario
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show'); // Mostrar un usuario
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Formulario de edición
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update'); // Actualizar usuario
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Eliminar usuario


    // insumos
    Route::get('/insumos', [InsumosController::class, 'index'])->name('insumos.index');
    Route::get('/insumos/create', [InsumosController::class, 'create'])->name('insumos.create');
    Route::post('/insumos', [InsumosController::class, 'store'])->name('insumos.store');
    Route::get('/insumos/{id}/edit', [InsumosController::class, 'edit'])->name('insumos.edit');
    Route::put('/insumos/{id}', [InsumosController::class, 'update'])->name('insumos.update');
    Route::delete('/insumos/{id}', [InsumosController::class, 'destroy'])->name('insumos.destroy');


    // stock
    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/create', [StocksController::class, 'create'])->name('stocks.create');
    Route::post('/stocks', [StocksController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/{id}/edit', [StocksController::class, 'edit'])->name('stocks.edit');
    Route::put('/stocks/{id}', [StocksController::class, 'update'])->name('stocks.update');
    Route::delete('/stocks/{id}', [StocksController::class, 'destroy'])->name('stocks.destroy');


    // almacenes
    Route::get('/almacenes', [AlmacenesController::class, 'index'])->name('almacenes.index');
    Route::get('/almacenes/create', [AlmacenesController::class, 'create'])->name('almacenes.create');
    Route::post('/almacenes', [AlmacenesController::class, 'store'])->name('almacenes.store');
    Route::get('/almacenes/{id}/edit', [AlmacenesController::class, 'edit'])->name('almacenes.edit');
    Route::put('/almacenes/{id}', [AlmacenesController::class, 'update'])->name('almacenes.update');
    Route::delete('/almacenes/{id}', [AlmacenesController::class, 'destroy'])->name('almacenes.destroy');


    // movimientos
    Route::get('/movimientos', [MovimientosController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/create', [MovimientosController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientosController::class, 'store'])->name('movimientos.store');
    Route::get('/movimientos/{id}/edit', [MovimientosController::class, 'edit'])->name('movimientos.edit');
    Route::put('/movimientos/{id}', [MovimientosController::class, 'update'])->name('movimientos.update');
    Route::delete('/movimientos/{id}', [MovimientosController::class, 'destroy'])->name('movimientos.destroy');


    // unidades productivas
    Route::get('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'index'])->name('unidades_de_produccion.index');
    Route::get('/unidades-de-produccion/create', [UnidadesDeProduccionController::class, 'create'])->name('unidades_de_produccion.create');
    Route::post('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'store'])->name('unidades_de_produccion.store');
    Route::get('/unidades-de-produccion/{id}/edit', [UnidadesDeProduccionController::class, 'edit'])->name('unidades_de_produccion.edit');
    Route::put('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'update'])->name('unidades_de_produccion.update');
    Route::delete('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'destroy'])->name('unidades_de_produccion.destroy');


    // provedores
    Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [ProveedoresController::class, 'create'])->name('proveedores.create');
    Route::post('/proveedores', [ProveedoresController::class, 'store'])->name('proveedores.store');
    Route::get('/proveedores/{id}/edit', [ProveedoresController::class, 'edit'])->name('proveedores.edit');
    Route::put('/proveedores/{id}', [ProveedoresController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{id}', [ProveedoresController::class, 'destroy'])->name('proveedores.destroy');
});




Route::middleware(['role:aprendiz'])->group(function () {




    // insumos
    Route::get('/insumos', [InsumosController::class, 'index'])->name('insumos.index');
    Route::get('/insumos/create', [InsumosController::class, 'create'])->name('insumos.create');
    

    // stock
    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.index');
    
    // almacenes
    Route::get('/almacenes', [AlmacenesController::class, 'index'])->name('almacenes.index');
    

    // movimientos
    Route::get('/movimientos', [MovimientosController::class, 'index'])->name('movimientos.index');
    Route::get('/movimiento           s/create', [MovimientosController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientosController::class, 'store'])->name('movimientos.store');
    Route::get('/movimientos/{id}/edit', [MovimientosController::class, 'edit'])->name('movimientos.edit');
    Route::put('/movimientos/{id}', [MovimientosController::class, 'update'])->name('movimientos.update');
    Route::delete('/movimientos/{id}', [MovimientosController::class, 'destroy'])->name('movimientos.destroy');


    // unidades productivas
    Route::get('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'index'])->name('unidades_de_produccion.index');
    Route::get('/unidades-de-produccion/create', [UnidadesDeProduccionController::class, 'create'])->name('unidades_de_produccion.create');
    Route::post('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'store'])->name('unidades_de_produccion.store');
    Route::get('/unidades-de-produccion/{id}/edit', [UnidadesDeProduccionController::class, 'edit'])->name('unidades_de_produccion.edit');
    Route::put('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'update'])->name('unidades_de_produccion.update');
    Route::delete('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'destroy'])->name('unidades_de_produccion.destroy');


    // provedores
    Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [ProveedoresController::class, 'create'])->name('proveedores.create');
    Route::post('/proveedores', [ProveedoresController::class, 'store'])->name('proveedores.store');
    Route::get('/proveedores/{id}/edit', [ProveedoresController::class, 'edit'])->name('proveedores.edit');
    Route::put('/proveedores/{id}', [ProveedoresController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{id}', [ProveedoresController::class, 'destroy'])->name('proveedores.destroy');
});





Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
