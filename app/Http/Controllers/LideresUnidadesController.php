<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\unidades_de_produccion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LideresUnidadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,instructor'); // Solo los administradores pueden gestionar líderes
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lideres = User::where('role', 'lider de la unidad')
                ->with('liderUnidades')
                ->select(['id', 'name', 'email', 'role', 'created_at']);

            return DataTables::of($lideres)
                ->addColumn('unidades', function ($user) {
                    return $user->liderUnidades->pluck('nombre')->implode(', ') ?: 'Ninguna';
                })
                ->make(true);
        }

        return view('lideres_unidades.index');
    }

    public function create()
    {
        $users = User::where('role', 'lider de la unidad')->get();
        $unidades = unidades_de_produccion::all();
        return view('lideres_unidades.create', compact('users', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'unidad_de_produccion_id' => 'required|exists:unidades_de_produccion,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $unidad = unidades_de_produccion::findOrFail($request->unidad_de_produccion_id);

        // Asignar el usuario como líder de la unidad
        $user->liderUnidades()->syncWithoutDetaching($unidad->id);

        return redirect()->route('lideres_unidades.index')->with('success', 'Líder asignado a la unidad exitosamente.');
    }

    public function edit($user_id)
    {
        $user = User::where('role', 'lider de la unidad')->findOrFail($user_id);
        $unidades = unidades_de_produccion::all();
        $asignadas = $user->liderUnidades->pluck('id')->toArray();

        dd($unidades,$user,$asignadas);
        return view('lideres_unidades.edit', compact('user', 'unidades', 'asignadas'));
    }

    public function update(Request $request, $user_id)
    {
        $request->validate([
            'unidades' => 'array',
            'unidades.*' => 'exists:unidades_de_produccion,id',
        ]);

        $user = User::findOrFail($user_id);
        $unidades = $request->unidades ?? [];

        // Actualizar las unidades asignadas al líder
        $user->liderUnidades()->sync($unidades);

        return redirect()->route('lideres_unidades.index')->with('success', 'Asignaciones actualizadas exitosamente.');
    }

    public function destroy($user_id, $unidad_id)
    {
        $user = User::findOrFail($user_id);
        $user->liderUnidades()->detach($unidad_id);

        return redirect()->route('lideres_unidades.index')->with('success', 'Asignación eliminada exitosamente.');
    }
}