<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProveedoresController extends Controller
{
    // Mostrar lista de proveedores
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Proveedor::select('id', 'nombre', 'nit', 'telefono', 'email', 'direccion', 'created_at');

                return DataTables::of($query)
                    ->editColumn('created_at', function (Proveedor $proveedor) {
                        return $proveedor->created_at->format('d/m/Y H:i');
                    })
                    ->addColumn('acciones', function (Proveedor $proveedor) {
                        return '
                            <a href="' . route('proveedores.edit', $proveedor->id) . '" class="inline-block px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200">
                                Editar
                            </a>
                            <form action="' . route('proveedores.destroy', $proveedor->id) . '" method="POST" class="inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="ml-2 inline-block px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 transition duration-200">
                                    Eliminar
                                </button>
                            </form>';
                    })
                    ->rawColumns(['acciones'])
                    ->make(true);
            } catch (\Exception $e) {
               echo "a";
            }
        }

        return view('proveedores.index');
    }

    // Mostrar formulario para crear un nuevo proveedor
    public function create()
    {
        return view('proveedores.create');
    }

    // Almacenar un nuevo proveedor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'nullable|string|max:20|unique:proveedores,nit',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:proveedores,email',
            'direccion' => 'nullable|string|max:500',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    // Mostrar formulario para editar un proveedor
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    // Actualizar un proveedor
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'nullable|string|max:20|unique:proveedores,nit,' . $proveedor->id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:proveedores,email,' . $proveedor->id,
            'direccion' => 'nullable|string|max:500',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar un proveedor
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}