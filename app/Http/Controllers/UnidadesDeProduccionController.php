<?php

namespace App\Http\Controllers;

use App\Models\unidades_de_produccion; // Using the exact name as requested
use Illuminate\Http\Request;

class UnidadesDeProduccionController extends Controller
{
    // Show the list of unidades de produccion
    public function index()
    {
        $unidades = unidades_de_produccion::all(); // Fetch all production units
        return view('unidades_de_produccion.index', compact('unidades'));
    }

    // Show the form to create a new unidad de produccion
    public function create()
    {
        return view('unidades_de_produccion.create');
    }

    // Store a new unidad de produccion
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $unidad = new unidades_de_produccion();
        $unidad->nombre = ucfirst(strtolower($request->nombre));
        $unidad->descripcion = $request->descripcion ? ucfirst(strtolower($request->descripcion)) : null;
        $unidad->save();

        return redirect()->route('unidades_de_produccion.index')->with('success', 'Unidad de producción creada exitosamente.');
    }

    // Show the form to edit an existing unidad de produccion
    public function edit($id)
    {
        $unidad = unidades_de_produccion::findOrFail($id);
        return view('unidades_de_produccion.edit', compact('unidad'));
    }

    // Update an existing unidad de produccion
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $unidad = unidades_de_produccion::findOrFail($id);
        $unidad->nombre = ucfirst(strtolower($request->nombre));
        $unidad->descripcion = $request->descripcion ? ucfirst(strtolower($request->descripcion)) : null;
        $unidad->save();

        return redirect()->route('unidades_de_produccion.index')->with('success', 'Unidad de producción actualizada exitosamente.');
    }

    // Delete an unidad de produccion
    public function destroy($id)
    {
        $unidad = unidades_de_produccion::findOrFail($id);
        $unidad->delete();

        return redirect()->route('unidades_de_produccion.index')->with('success', 'Unidad de producción eliminada exitosamente.');
    }
}