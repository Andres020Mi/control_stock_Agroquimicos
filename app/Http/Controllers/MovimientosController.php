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

    // Mostrar formulario de creación
    public function create()
    {
        $stocks = Stock::with('insumo', 'almacen')->where('estado', 'utilizable')->get();
        $unidades = unidades_de_produccion::all(); // Cambio aquí: modelo con el nuevo nombre
        return view('movimientos.create', compact('stocks', 'unidades'));
    }

    // Guardar un nuevo movimiento
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'id_stock' => 'required|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'id_unidad_de_produccion' => 'nullable|exists:unidades_de_produccion,id',
        ]);

        $stock = Stock::findOrFail($request->id_stock);

        // Verificar stock en caso de salida
        if ($request->tipo === 'salida') {
            if ($stock->cantidad < $request->cantidad) {
                return back()->withErrors(['cantidad' => 'La cantidad solicitada excede el stock disponible.']);
            }
            $stock->cantidad -= $request->cantidad;
        } elseif ($request->tipo === 'entrada') {
            $stock->cantidad += $request->cantidad;
        }

        // Actualizar estado del stock si es necesario
        if ($stock->cantidad == 0) {
            $stock->estado = 'caducado';
        }
        $stock->save();

        // Crear el movimiento
        $movimiento = new Movimiento();
        $movimiento->id_user = Auth::id();
        $movimiento->tipo = $request->tipo;
        $movimiento->id_stock = $request->id_stock;
        $movimiento->cantidad = $request->cantidad;
        $movimiento->id_unidad_de_produccion = $request->id_unidad_de_produccion;
        $movimiento->save();

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado exitosamente.');
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
