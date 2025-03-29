<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProveedoresController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Proveedor::select('id', 'nombre', 'nit', 'telefono', 'email', 'direccion', 'created_at');

            return DataTables::of($query)
                ->editColumn('created_at', function (Proveedor $proveedor) {
                    return $proveedor->created_at->format('d/m/Y H:i');
                })
                ->addColumn('acciones', function (Proveedor $proveedor) {
                    return '
                        <a href="' . route('proveedores.edit', $proveedor->id) . '" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                        <form action="' . route('proveedores.destroy', $proveedor->id) . '" method="POST" class="inline delete-form">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash mr-1"></i> Eliminar
                            </button>
                        </form>';
                })
                ->rawColumns(['acciones'])
                ->make(true);
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
            'nit' => 'nullable|string|max:20', // Sin unique
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255', // Sin unique
            'direccion' => 'nullable|string|max:500',
        ]);

        $data = [
            'nombre' => ucfirst(strtolower($request->nombre)),
            'nit' => $request->nit ? ucfirst(strtolower($request->nit)) : null,
            'telefono' => $request->telefono ? ucfirst(strtolower($request->telefono)) : null,
            'email' => $request->email ? strtolower($request->email) : null,
            'direccion' => $request->direccion ? ucfirst(strtolower($request->direccion)) : null,
        ];

        Proveedor::create($data);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    // Mostrar formulario para editar un proveedor
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return redirect()->route('proveedores.index')->with('error', 'Proveedor no encontrado.');
        }

        return view('proveedores.edit', compact('proveedor'));
    }

    // Actualizar un proveedor
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'nullable|string|max:20', // Sin unique
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255', // Sin unique
            'direccion' => 'nullable|string|max:500',
        ]);

        $data = [
            'nombre' => ucfirst(strtolower($request->nombre)),
            'nit' => $request->nit ? ucfirst(strtolower($request->nit)) : null,
            'telefono' => $request->telefono ? ucfirst(strtolower($request->telefono)) : null,
            'email' => $request->email ? strtolower($request->email) : null,
            'direccion' => $request->direccion ? ucfirst(strtolower($request->direccion)) : null,
        ];

        $proveedor->update($data);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar un proveedor
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}