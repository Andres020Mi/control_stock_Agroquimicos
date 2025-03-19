<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Stock;
use App\Models\unidades_de_produccion; // Cambio aquí: nombre del modelo en minúsculas y con guiones bajos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientosController extends Controller
{
    // Mostrar lista de movimientos
    public function index()
    {
        $movimientos = Movimiento::with(['stock.insumo', 'stock.almacen', 'unidadDeProduccion', 'user'])->get();
        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $stocks = Stock::with('insumo', 'almacen')->where('estado', 'utilizable')->get();
        $unidades = unidades_de_produccion::all();
        return view('movimientos.create', compact('stocks', 'unidades'));
    }

    // Guardar un nuevo movimiento
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'id_stock' => 'required|exists:stocks,id',
            'unidades' => 'required_if:tipo,salida|array', // Requerido solo para salidas
            'unidades.*' => 'exists:unidades_de_produccion,id',
            'cantidades' => 'required_if:tipo,salida|array', // Requerido solo para salidas
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
            $totalCantidad = array_sum($cantidades ?: [0]); // Si no hay cantidades, usar 0
            $stock->cantidad += $totalCantidad;
        }

        // Actualizar estado del stock
        $stock->estado = $stock->cantidad > 0 ? 'utilizable' : 'caducado';
        $stock->save();

        // Crear movimientos solo si hay unidades seleccionadas (para salidas)
        if ($tipo === 'salida' && !empty($unidades)) {
            foreach ($unidades as $index => $unidadId) {
                $movimiento = new Movimiento();
                $movimiento->id_user = Auth::id();
                $movimiento->tipo = $tipo;
                $movimiento->id_stock = $request->id_stock;
                $movimiento->cantidad = $cantidades[$index];
                $movimiento->id_unidad_de_produccion = $unidadId;
                $movimiento->save();
            }
        } else { // Para entradas, un solo movimiento sin unidad (o con una si se especifica)
            $movimiento = new Movimiento();
            $movimiento->id_user = Auth::id();
            $movimiento->tipo = $tipo;
            $movimiento->id_stock = $request->id_stock;
            $movimiento->cantidad = $totalCantidad ?: $request->input('cantidades.0', 0); // Usar primera cantidad si existe
            $movimiento->id_unidad_de_produccion = null; // No se usa para entradas generalmente
            $movimiento->save();
        }

        return redirect()->route('movimientos.index')->with('success', 'Movimientos registrados exitosamente.');
    }

    // Show the form to edit an existing movimiento
    public function edit($id)
    {
        $movimiento = Movimiento::with(['stock.insumo', 'stock.almacen', 'unidadDeProduccion'])->findOrFail($id);
        $stocks = Stock::with('insumo', 'almacen')->where('estado', 'utilizable')->get();
        $unidades = unidades_de_produccion::all();
        return view('movimientos.edit', compact('movimiento', 'stocks', 'unidades'));
    }

    // Update an existing movimiento
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'id_stock' => 'required|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'id_unidad_de_produccion' => 'nullable|exists:unidades_de_produccion,id',
        ]);

        $movimiento = Movimiento::findOrFail($id);
        $oldStock = Stock::findOrFail($movimiento->id_stock);
        $newStock = Stock::findOrFail($request->id_stock);

        // Revert the old stock change
        if ($movimiento->tipo === 'salida') {
            $oldStock->cantidad += $movimiento->cantidad;
        } elseif ($movimiento->tipo === 'entrada') {
            $oldStock->cantidad -= $movimiento->cantidad;
        }
        $oldStock->estado = $oldStock->cantidad > 0 ? 'utilizable' : 'caducado';
        $oldStock->save();

        // Apply the new stock change
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

        // Update the movimiento
        $movimiento->tipo = $request->tipo;
        $movimiento->id_stock = $request->id_stock;
        $movimiento->cantidad = $request->cantidad;
        $movimiento->id_unidad_de_produccion = $request->id_unidad_de_produccion;
        $movimiento->save();

        return redirect()->route('movimientos.index')->with('success', 'Movimiento actualizado exitosamente.');
    }

    // Delete a movimiento
    public function destroy($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $stock = Stock::findOrFail($movimiento->id_stock);

        // Revert the stock change before deletion
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
}
