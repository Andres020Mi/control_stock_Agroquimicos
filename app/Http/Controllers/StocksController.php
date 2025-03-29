<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Insumo;
use App\Models\Almacen;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StocksController extends Controller
{
    // Show the list of stocks
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stocks = Stock::with(['insumo', 'almacen', 'proveedor'])->select([
                'id',
                'id_insumo',
                'cantidad',
                'cantidad_inicial',
                'fecha_de_vencimiento',
                'id_almacen',
                'id_proveedor',
                'estado'
            ]);
    
            return DataTables::of($stocks)
                ->addColumn('insumo_nombre', function ($stock) {
                    return $stock->insumo ? $stock->insumo->nombre : 'N/A';
                })
                ->addColumn('unidad_de_medida', function ($stock) {
                    return $stock->insumo ? $stock->insumo->unidad_de_medida : '';
                })
                ->addColumn('almacen_nombre', function ($stock) {
                    return $stock->almacen ? $stock->almacen->nombre : 'N/A';
                })
                ->addColumn('proveedor_nombre', function ($stock) {
                    return $stock->proveedor ? $stock->proveedor->nombre : 'Sin proveedor';
                })
                ->editColumn('fecha_de_vencimiento', function ($stock) {
                    return $stock->fecha_de_vencimiento ? $stock->fecha_de_vencimiento->format('d/m/Y') : 'N/A';
                })
                ->addColumn('acciones', function ($stock) {
                    return '
                        <div class="actions">
                            <a href="' . route('stocks.edit', $stock->id) . '" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="' . route('stocks.destroy', $stock->id) . '" method="POST" class="inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>';
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }
    
        return view('stocks.index');
    }

    // Show the form to create a new stock
    public function create()
    {
        $insumos = Insumo::all();
        $almacenes = Almacen::all();
        $proveedores = Proveedor::all(); // Cargar proveedores para dropdown
        return view('stocks.create', compact('insumos', 'almacenes', 'proveedores'));
    }

    // Store a new stock
    public function store(Request $request)
    {
        $request->validate([
            'id_insumo' => 'required|exists:insumos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_de_vencimiento' => 'required|date|after:today',
            'id_almacen' => 'required|exists:almacenes,id',
            'id_proveedor' => 'nullable|exists:proveedores,id', // Validación para proveedor
        ]);

        $stock = new Stock();
        $stock->id_insumo = $request->id_insumo;
        $stock->cantidad = $request->cantidad;
        $stock->fecha_de_vencimiento = $request->fecha_de_vencimiento;
        $stock->id_almacen = $request->id_almacen;
        $stock->id_proveedor = $request->id_proveedor; // Nuevo campo
        $stock->estado = ucfirst(strtolower('utilizable')); // Valor por defecto transformado
        $stock->cantidad_inicial = $request->cantidad; // Nota: Este campo está en la migración actualizada
        $stock->save();

        return redirect()->route('stocks.index')->with('success', 'Stock creado exitosamente.');
    }

    // Show the form to edit an existing stock
    public function edit($id)
    {
        $stock = Stock::with(['insumo', 'almacen', 'proveedor'])->findOrFail($id); // Agregar proveedor
        $insumos = Insumo::all(); // Para referencia (puede ser read-only)
        $almacenes = Almacen::all();
        $proveedores = Proveedor::all(); // Cargar proveedores para dropdown
        return view('stocks.edit', compact('stock', 'insumos', 'almacenes', 'proveedores'));
    }

    // Update an existing stock
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:0',
            'fecha_de_vencimiento' => 'required|date|after:today',
            'id_almacen' => 'required|exists:almacenes,id',
            'id_proveedor' => 'nullable|exists:proveedores,id', // Validación para proveedor
            'estado' => 'required|in:caducado,utilizable', // Nota: 'agotado' no está incluido aquí
        ]);

        $stock = Stock::findOrFail($id);
        $stock->cantidad = $request->cantidad;
        $stock->fecha_de_vencimiento = $request->fecha_de_vencimiento;
        $stock->id_almacen = $request->id_almacen;
        $stock->id_proveedor = $request->id_proveedor; // Nuevo campo
        $stock->estado = ucfirst(strtolower($request->estado)); // Transformar estado
        $stock->save();

        return redirect()->route('stocks.index')->with('success', 'Stock actualizado exitosamente.');
    }

    // Delete a stock
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock eliminado exitosamente.');
    }
}