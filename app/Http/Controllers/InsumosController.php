<?php

namespace App\Http\Controllers;

use App\Models\Insumo; // Assuming you’ll create this model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsumosController extends Controller
{
    // Show the list of insumos
    public function index()
    {
        $insumos = Insumo::all(); // Fetch all insumos
        return view('insumos.index', compact('insumos'));
    }

    // Show the form to create a new insumo
    public function create()
    {
        return view('insumos.create');
    }

    // Store a new insumo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'composicion_quimica' => 'required|string|max:255',
            'unidad_de_medida' => 'required|in:kg,g,l,ml',
            'imagen' => 'nullable|image|max:2048', // Max 2MB image
        ]);

        $insumo = new Insumo();
        $insumo->nombre = $request->nombre;
        $insumo->composicion_quimica = $request->composicion_quimica;
        $insumo->unidad_de_medida = $request->unidad_de_medida;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('insumos', 'public'); // Store in storage/app/public/insumos
            $insumo->imagen = $path;
        }

        $insumo->save();

        return redirect()->route('insumos.index')->with('success', 'Insumo creado exitosamente.');
    }

    public function edit($id)
    {
        $insumo = Insumo::findOrFail($id);
        return view('insumos.edit', compact('insumo'));
    }

    // Update an existing insumo
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'composicion_quimica' => 'required|string|max:255',
            'unidad_de_medida' => 'required|in:kg,g,l,ml',
            'imagen' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $insumo = Insumo::findOrFail($id);
        $insumo->nombre = $request->nombre;
        $insumo->composicion_quimica = $request->composicion_quimica;
        $insumo->unidad_de_medida = $request->unidad_de_medida;

        if ($request->hasFile('imagen')) {
            // Delete old image if it exists
            if ($insumo->imagen) {
                Storage::delete('public/' . $insumo->imagen);
            }
            // Store new image
            $insumo->imagen = $request->file('imagen')->store('insumos', 'public');
        }

        $insumo->save();

        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado exitosamente.');
    }

    // Delete an insumo
    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        // Delete image if it exists
        if ($insumo->imagen) {
            Storage::delete('public/' . $insumo->imagen);
        }
        $insumo->delete();

        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado exitosamente.');
    }
}