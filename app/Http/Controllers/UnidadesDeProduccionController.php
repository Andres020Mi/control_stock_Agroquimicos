<?php

namespace App\Http\Controllers;

use App\Models\unidades_de_produccion; // Mantengo el nombre exacto del modelo
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnidadesDeProduccionController extends Controller
{
    // Show the list of unidades de produccion
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $unidades = unidades_de_produccion::select(['id', 'nombre', 'descripcion']);

            return DataTables::of($unidades)
                ->addColumn('acciones', function ($unidad) {
                    return '
                        <div class="actions">
                            <a href="' . route('unidades_de_produccion.edit', $unidad->id) . '" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="' . route('unidades_de_produccion.destroy', $unidad->id) . '" method="POST" class="inline delete-form">
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

        return view('unidades_de_produccion.index');
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