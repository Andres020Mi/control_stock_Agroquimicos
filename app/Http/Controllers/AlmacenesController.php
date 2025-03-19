<?php

namespace App\Http\Controllers;

use App\Models\Almacen; // Assuming the model exists
use Illuminate\Http\Request;

class AlmacenesController extends Controller
{
    // Show the list of almacenes
    public function index()
    {
        $almacenes = Almacen::all(); // Fetch all warehouses
        return view('almacenes.index', compact('almacenes'));
    }

    // Show the form to create a new almacen
    public function create()
    {
        return view('almacenes.create');
    }

    // Store a new almacen
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $almacen = new Almacen();
        $almacen->nombre = $request->nombre;
        $almacen->descripcion = $request->descripcion;
        $almacen->save();

        return redirect()->route('almacenes.index')->with('success', 'Almacén creado exitosamente.');
    }

    public function edit($id)
    {
        $almacen = Almacen::findOrFail($id);
        return view('almacenes.edit', compact('almacen'));
    }

    // Update an existing almacen
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $almacen = Almacen::findOrFail($id);
        $almacen->nombre = $request->nombre;
        $almacen->descripcion = $request->descripcion;
        $almacen->save();

        return redirect()->route('almacenes.index')->with('success', 'Almacén actualizado exitosamente.');
    }

    // Delete an almacen
    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->delete();

        return redirect()->route('almacenes.index')->with('success', 'Almacén eliminado exitosamente.');
    }
}