<?php

namespace App\Http\Controllers;

use App\Models\Stock; // Assuming you’ll create this model
use App\Models\Insumo;
use App\Models\Almacen;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    // Show the list of stocks
    public function index()
    {
        $stocks = Stock::with(['insumo', 'almacen'])->get(); // Eager load relationships
        return view('stocks.index', compact('stocks'));
    }

    // Show the form to create a new stock
    public function create()
    {
        $insumos = Insumo::all(); // Fetch all insumos for dropdown
        $almacenes = Almacen::all(); // Fetch all almacenes for dropdown
        return view('stocks.create', compact('insumos', 'almacenes'));
    }

    // Store a new stock
    public function store(Request $request)
    {
        $request->validate([
            'id_insumo' => 'required|exists:insumos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_de_vencimiento' => 'required|date|after:today',
            'id_almacen' => 'required|exists:almacenes,id',
        ]);

        $stock = new Stock();
        $stock->id_insumo = $request->id_insumo;
        $stock->cantidad = $request->cantidad;
        $stock->fecha_de_vencimiento = $request->fecha_de_vencimiento;
        $stock->id_almacen = $request->id_almacen;
        $stock->estado = 'utilizable'; // Default value as per your migration
        $stock->save();

        return redirect()->route('stocks.index')->with('success', 'Stock creado exitosamente.');
    }


    public function edit($id)
    {
        $stock = Stock::with(['insumo', 'almacen'])->findOrFail($id);
        $insumos = Insumo::all(); // For reference (read-only in view)
        $almacenes = Almacen::all(); // For dropdown
        return view('stocks.edit', compact('stock', 'insumos', 'almacenes'));
    }

    // Update an existing stock
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:0',
            'fecha_de_vencimiento' => 'required|date|after:today',
            'id_almacen' => 'required|exists:almacenes,id',
            'estado' => 'required|in:caducado,utilizable',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->cantidad = $request->cantidad;
        $stock->fecha_de_vencimiento = $request->fecha_de_vencimiento;
        $stock->id_almacen = $request->id_almacen;
        $stock->estado = $request->estado;
        $stock->save();

        return redirect()->route('stocks.index')->with('success', 'Stock actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock eliminado exitosamente.');
    }
}