<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Stock;

use App\Models\unidades_de_produccion;
use App\Models\SolicitudMovimiento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MovimientosController extends Controller
{
    // Método para verificar si el usuario tiene permiso para modificar un movimiento directamente
    private function authorizeMovimiento(Movimiento $movimiento)
    {
        $user = auth()->user();

        // Los administradores e instructores tienen acceso completo
        if (in_array($user->role, ['admin', 'instructor'])) {
            return true;
        }

        // Los líderes de unidad solo pueden crear movimientos, no editar ni eliminar directamente
        abort(403, 'No tienes permisos para realizar esta acción directamente. Debes crear una solicitud.');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movimientos = Movimiento::with(['stock.insumo', 'stock.almacen', 'unidadDeProduccion', 'user'])
                ->select('movimientos.*');
    
            return DataTables::of($movimientos)
                ->addColumn('insumo_nombre', function ($movimiento) {
                    return $movimiento->stock->insumo->nombre ?? 'N/A';
                })
                ->addColumn('cantidad_unidad', function ($movimiento) {
                    return $movimiento->cantidad . ' ' . ($movimiento->stock->insumo->unidad_de_medida ?? '');
                })
                ->addColumn('almacen_nombre', function ($movimiento) {
                    return $movimiento->stock->almacen->nombre ?? 'N/A';
                })
                ->addColumn('unidad_produccion_nombre', function ($movimiento) {
                    return $movimiento->unidadDeProduccion ? $movimiento->unidadDeProduccion->nombre : 'N/A';
                })
                ->addColumn('usuario_nombre', function ($movimiento) {
                    return $movimiento->user->name ?? 'N/A';
                })
                ->addColumn('acciones', function ($movimiento) {
                    $user = auth()->user();
                    if (in_array($user->role, ['admin', 'instructor'])) {
                        return [
                            'edit_url' => route('movimientos.edit', $movimiento->id),
                            'delete_url' => route('movimientos.destroy', $movimiento->id),
                        ];
                    } else {
                        return [
                            'edit_url' => route('movimientos.solicitarEdicion', $movimiento->id),
                            'delete_url' => route('movimientos.solicitarEliminacion', $movimiento->id),
                        ];
                    }
                })
                ->make(true);
        }
    
        return view('movimientos.index');
    }

    public function create()
    {
        $stocks = Stock::with(['insumo', 'almacen', 'proveedor'])->where('estado', 'utilizable')->get();
        $unidades = unidades_de_produccion::all();

        return view('movimientos.create', compact('stocks', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'id_stock' => 'required|exists:stocks,id',
            'unidades' => 'required_if:tipo,salida|array',
            'unidades.*' => 'exists:unidades_de_produccion,id',
            'cantidades' => 'required_if:tipo,salida|array',
            'cantidades.*' => 'integer|min:1',
        ]);

        $stock = Stock::findOrFail($request->id_stock);
        $tipo = $request->tipo;
        $unidades = $request->input('unidades', []);
        $cantidades = $request->input('cantidades', []);

        // Validar que las cantidades no excedan el stock para salidas
        if ($tipo === 'salida') {
            $totalCantidad = array_sum($cantidades);
            if ($stock->cantidad < $totalCantidad) {
                return back()->withErrors(['cantidades' => 'La suma de las cantidades excede el stock disponible (' . $stock->cantidad . ').']);
            }
            $stock->cantidad -= $totalCantidad;
        } else { // Entrada
            $totalCantidad = array_sum($cantidades ?: [0]);
            $stock->cantidad += $totalCantidad;
        }

        $stock->estado = $stock->cantidad > 0 ? 'utilizable' : 'caducado';
        $stock->save();

        // Crear movimientos
        if ($tipo === 'salida' && !empty($unidades)) {
            foreach ($unidades as $index => $unidadId) {
                Movimiento::create([
                    'id_user' => Auth::id(),
                    'tipo' => $tipo,
                    'id_stock' => $request->id_stock,
                    'cantidad' => $cantidades[$index],
                    'id_unidad_de_produccion' => $unidadId,
                ]);
            }
        } else {
            Movimiento::create([
                'id_user' => Auth::id(),
                'tipo' => $tipo,
                'id_stock' => $request->id_stock,
                'cantidad' => $totalCantidad ?: $request->input('cantidades.0', 0),
                'id_unidad_de_produccion' => null,
            ]);
        }

        return redirect()->route('movimientos.index')->with('success', 'Movimientos registrados exitosamente.');
    }

    public function edit($id)
    {
        $movimiento = Movimiento::with(['stock.insumo', 'stock.almacen', 'unidades_de_produccion'])->findOrFail($id);
        $this->authorizeMovimiento($movimiento);
        $stocks = Stock::with('insumo', 'almacen')->where('estado', 'utilizable')->get();
        $unidades = unidades_de_produccion::all();
        return view('movimientos.edit', compact('movimiento', 'stocks', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $this->authorizeMovimiento($movimiento);

        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'id_stock' => 'required|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'id_unidad_de_produccion' => 'nullable|exists:unidades_de_produccion,id',
        ]);

        $oldStock = Stock::findOrFail($movimiento->id_stock);
        $newStock = Stock::findOrFail($request->id_stock);

        // Revertir el stock anterior
        if ($movimiento->tipo === 'salida') {
            $oldStock->cantidad += $movimiento->cantidad;
        } elseif ($movimiento->tipo === 'entrada') {
            $oldStock->cantidad -= $movimiento->cantidad;
        }
        $oldStock->estado = $oldStock->cantidad > 0 ? 'utilizable' : 'caducado';
        $oldStock->save();

        // Aplicar al nuevo stock
        if ($request->tipo === 'salida') {
            if ($newStock->cantidad < $request->cantidad) {
                return back()->withErrors(['cantidad' => 'La cantidad solicitada excede el stock disponible.']);
            }
            $newStock->cantidad -= $request->cantidad;
        } elseif ($request->tipo === 'entrada') {
            $newStock->cantidad += $request->cantidad;
        }
        $newStock->estado = $newStock->cantidad > 0 ? 'utilizable' : 'caducado';
        $newStock->save();

        // Actualizar el movimiento
        $movimiento->update([
            'tipo' => $request->tipo,
            'id_stock' => $request->id_stock,
            'cantidad' => $request->cantidad,
            'id_unidad_de_produccion' => $request->id_unidad_de_produccion,
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $this->authorizeMovimiento($movimiento);

        $stock = Stock::findOrFail($movimiento->id_stock);

        // Revertir el stock
        if ($movimiento->tipo === 'salida') {
            $stock->cantidad += $movimiento->cantidad;
        } elseif ($movimiento->tipo === 'entrada') {
            $stock->cantidad -= $movimiento->cantidad;
        }
        $stock->estado = $stock->cantidad > 0 ? 'utilizable' : 'caducado';
        $stock->save();

        $movimiento->delete();

        return redirect()->route('movimientos.index')->with('success', 'Movimiento eliminado exitosamente.');
    }

    public function solicitarEdicion(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $user = auth()->user();

        if ($user->role === 'lider de la unidad') {
            $unidadId = $movimiento->id_unidad_de_produccion;
            if (!$unidadId || !$user->liderUnidades->contains($unidadId)) {
                abort(403, 'No tienes permisos para solicitar cambios en este movimiento.');
            }
        }

        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'id_stock' => 'required|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'id_unidad_de_produccion' => 'nullable|exists:unidades_de_produccion,id',
        ]);

        SolicitudMovimiento::create([
            'user_id' => $user->id,
            'movimiento_id' => $movimiento->id,
            'tipo' => 'editar',
            'datos_nuevos' => [
                'tipo' => $request->tipo,
                'id_stock' => $request->id_stock,
                'cantidad' => $request->cantidad,
                'id_unidad_de_produccion' => $request->id_unidad_de_produccion,
            ],
            'estado' => 'pendiente',
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Solicitud de edición enviada. Un administrador o instructor la revisará.');
    }

    public function solicitarEliminacion($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $user = auth()->user();

        if ($user->role === 'lider de la unidad') {
            $unidadId = $movimiento->id_unidad_de_produccion;
            if (!$unidadId || !$user->liderUnidades->contains($unidadId)) {
                abort(403, 'No tienes permisos para solicitar la eliminación de este movimiento.');
            }
        }

        SolicitudMovimiento::create([
            'user_id' => $user->id,
            'movimiento_id' => $movimiento->id,
            'tipo' => 'eliminar',
            'estado' => 'pendiente',
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Solicitud de eliminación enviada. Un administrador o instructor la revisará.');
    }
}