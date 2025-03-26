<?php

use App\Http\Controllers\InsumosController;
use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\LideresUnidadesController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\SolicitudesMovimientosController;
use App\Http\Controllers\UnidadesDeProduccionController;
use Illuminate\Support\Facades\Route;

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

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {



    // Rutas para gestionar la informacion como administradores
    Route::middleware(['role:admin,instructor'])->group(function () {
        // Gestionar usuarios
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Gestionar insumos
        Route::get('/insumos/create', [InsumosController::class, 'create'])->name('insumos.create');
        Route::post('/insumos', [InsumosController::class, 'store'])->name('insumos.store');
        Route::get('/insumos/{id}/edit', [InsumosController::class, 'edit'])->name('insumos.edit');
        Route::put('/insumos/{id}', [InsumosController::class, 'update'])->name('insumos.update');
        Route::delete('/insumos/{id}', [InsumosController::class, 'destroy'])->name('insumos.destroy');

        // Gestionar unidades
        Route::get('/lideres-unidades', [LideresUnidadesController::class, 'index'])->name('lideres_unidades.index');
        Route::get('/lideres-unidades/create', [LideresUnidadesController::class, 'create'])->name('lideres_unidades.create');
        Route::post('/lideres-unidades', [LideresUnidadesController::class, 'store'])->name('lideres_unidades.store');
        Route::get('/lideres-unidades/{user_id}/edit', [LideresUnidadesController::class, 'edit'])->name('lideres_unidades.edit');
        Route::put('/lideres-unidades/{user_id}', [LideresUnidadesController::class, 'update'])->name('lideres_unidades.update');
        Route::delete('/lideres-unidades/{user_id}/{unidad_id}', [LideresUnidadesController::class, 'destroy'])->name('lideres_unidades.destroy');

        Route::get('/stocks/create', [StocksController::class, 'create'])->name('stocks.create');
        Route::post('/stocks', [StocksController::class, 'store'])->name('stocks.store');
        Route::get('/stocks/{id}/edit', [StocksController::class, 'edit'])->name('stocks.edit');
        Route::put('/stocks/{id}', [StocksController::class, 'update'])->name('stocks.update');
        Route::delete('/stocks/{id}', [StocksController::class, 'destroy'])->name('stocks.destroy');

        Route::get('/almacenes/create', [AlmacenesController::class, 'create'])->name('almacenes.create');
        Route::post('/almacenes', [AlmacenesController::class, 'store'])->name('almacenes.store');
        Route::get('/almacenes/{id}/edit', [AlmacenesController::class, 'edit'])->name('almacenes.edit');
        Route::put('/almacenes/{id}', [AlmacenesController::class, 'update'])->name('almacenes.update');
        Route::delete('/almacenes/{id}', [AlmacenesController::class, 'destroy'])->name('almacenes.destroy');

        Route::get('/movimientos/create', [MovimientosController::class, 'create'])->name('movimientos.create');
        Route::post('/movimientos', [MovimientosController::class, 'store'])->name('movimientos.store');
        Route::get('/movimientos/{id}/edit', [MovimientosController::class, 'edit'])->name('movimientos.edit');
        Route::put('/movimientos/{id}', [MovimientosController::class, 'update'])->name('movimientos.update');
        Route::delete('/movimientos/{id}', [MovimientosController::class, 'destroy'])->name('movimientos.destroy');

        Route::get('/unidades-de-produccion/create', [UnidadesDeProduccionController::class, 'create'])->name('unidades_de_produccion.create');
        Route::post('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'store'])->name('unidades_de_produccion.store');
        Route::get('/unidades-de-produccion/{id}/edit', [UnidadesDeProduccionController::class, 'edit'])->name('unidades_de_produccion.edit');
        Route::put('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'update'])->name('unidades_de_produccion.update');
        Route::delete('/unidades-de-produccion/{id}', [UnidadesDeProduccionController::class, 'destroy'])->name('unidades_de_produccion.destroy');


        Route::get('/proveedores/create', [ProveedoresController::class, 'create'])->name('proveedores.create');
        Route::post('/proveedores', [ProveedoresController::class, 'store'])->name('proveedores.store');
        Route::get('/proveedores/{id}/edit', [ProveedoresController::class, 'edit'])->name('proveedores.edit');
        Route::put('/proveedores/{id}', [ProveedoresController::class, 'update'])->name('proveedores.update');
        Route::delete('/proveedores/{id}', [ProveedoresController::class, 'destroy'])->name('proveedores.destroy');

        Route::get('/movimientos/solicitudes-movimientos', [SolicitudesMovimientosController::class, 'index'])->name('solicitudes_movimientos.index');
    });


    // rutas para los Lideres de unidades
    Route::middleware(['role:admin,instructor,lider de la unidad'])->group(function () {
        // Rutas para solicitar la edicion o eliminacion de un registro echo
        Route::post('/movimientos/{id}/solicitar-edicion', [MovimientosController::class, 'solicitarEdicion'])->name('movimientos.solicitar_edicion');
        Route::delete('/movimientos/{id}/solicitar-eliminacion', [MovimientosController::class, 'solicitarEliminacion'])->name('movimientos.solicitar_eliminacion');
        // Rutas para solicitar edición y eliminación de movimientos
        Route::get('movimientos/{movimiento}/solicitar-edicion', [MovimientosController::class, 'solicitarEdicion'])->name('movimientos.solicitarEdicion');
        Route::delete('movimientos/{movimiento}/solicitar-eliminacion', [MovimientosController::class, 'solicitarEliminacion'])->name('movimientos.solicitarEliminacion');
    });


    // Rutas para aprendizes y resto de roles sin rango solo vizualizar 

    Route::middleware(['role:admin,aprendiz,instructor,lider de la unidad'])->group(function () {
        // Insumos
        Route::get('/insumos', [InsumosController::class, 'index'])->name('insumos.index');


        // Stock
        Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.index');


        // Almacenes
        Route::get('/almacenes', [AlmacenesController::class, 'index'])->name('almacenes.index');


        // Movimientos
        Route::get('/movimientos', [MovimientosController::class, 'index'])->name('movimientos.index');


        // Unidades de Producción
        Route::get('/unidades-de-produccion', [UnidadesDeProduccionController::class, 'index'])->name('unidades_de_produccion.index');

        // Proveedores
        Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
