<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AlmacenesController extends Controller
{
    // Show the list of almacenes
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $almacenes = Almacen::select(['id', 'nombre', 'descripcion']);

            return DataTables::of($almacenes)
                ->addColumn('acciones', function ($almacen) {
                    return '<a href="' . route('almacenes.edit', $almacen->id) . '" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>' .
                           '<form action="' . route('almacenes.destroy', $almacen->id) . '" method="POST" class="inline delete-form">' .
                           csrf_field() . method_field('DELETE') .
                           '<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button></form>';
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }

        return view('almacenes.index');
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
        $almacen->nombre = ucfirst(strtolower($request->nombre));
        $almacen->descripcion = $request->descripcion ? ucfirst(strtolower($request->descripcion)) : null;
        $almacen->save();

        return redirect()->route('almacenes.index')->with('success', 'Almacén creado exitosamente.');
    }

    // Show the form to edit an existing almacen
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
        $almacen->nombre = ucfirst(strtolower($request->nombre));
        $almacen->descripcion = $request->descripcion ? ucfirst(strtolower($request->descripcion)) : null;
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