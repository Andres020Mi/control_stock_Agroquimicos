<?php

namespace App\Http\Controllers;

use App\Models\SolicitudMovimiento;
use App\Models\Movimiento;
use App\Models\Stock;
use App\Models\UnidadDeProduccion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SolicitudesMovimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,instructor'); // Solo admin e instructores pueden gestionar solicitudes
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $solicitudes = SolicitudMovimiento::with(['user', 'movimiento', 'aprobador'])
                ->select(['id', 'user_id', 'movimiento_id', 'tipo', 'estado', 'created_at']);

            return DataTables::of($solicitudes)
                ->addColumn('solicitante', function ($solicitud) {
                    return $solicitud->user->name;
                })
                ->addColumn('movimiento', function ($solicitud) {
                    // Verificar si el movimiento existe para evitar errores
                    return $solicitud->movimiento
                        ? $solicitud->movimiento->id . ' (' . $solicitud->movimiento->tipo . ')'
                        : 'Movimiento eliminado';
                })
                ->addColumn('acciones', function ($solicitud) {
                    if ($solicitud->estado === 'pendiente') {
                        return '
                            <div class="flex space-x-2">
                                <a href="' . route('solicitudes_movimientos.edit', $solicitud->id) . '" class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-200">
                                    Revisar
                                </a>
                            </div>
                        ';
                    }
                    return $solicitud->estado;
                })
                ->make(true);
        }

        return view('solicitudes_movimientos.index');
    }

    public function edit($id)
    {
        $solicitud = SolicitudMovimiento::with(['movimiento', 'user'])->findOrFail($id);
        $stocks = Stock::with('insumo', 'almacen')->get();
        $unidades = UnidadDeProduccion::all();

        // Verificar si el movimiento existe
        if (!$solicitud->movimiento) {
            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'El movimiento asociado a esta solicitud ya no existe.');
        }

        return view('solicitudes_movimientos.edit', compact('solicitud', 'stocks', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        $solicitud = SolicitudMovimiento::findOrFail($id);
        $movimiento = $solicitud->movimiento;

        // Verificar si el usuario autenticado es el mismo que creó la solicitud
        if (auth()->id() === $solicitud->user_id) {
            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'No puedes aprobar o rechazar tu propia solicitud.');
        }

        // Verificar si el movimiento existe
        if (!$movimiento) {
            $solicitud->update([
                'estado' => 'rechazada',
                'aprobador_id' => auth()->id(),
                'fecha_aprobacion' => now(),
                'motivo_rechazo' => 'El movimiento ya no existe.',
            ]);

            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'El movimiento asociado a esta solicitud ya no existe. La solicitud ha sido marcada como rechazada.');
        }

        // Validar la solicitud
        $request->validate([
            'estado' => 'required|in:aprobada,rechazada',
            'motivo_rechazo' => 'required_if:estado,rechazada',
        ]);

        // Actualizar la solicitud
        $solicitud->update([
            'estado' => $request->estado,
            'aprobador_id' => auth()->id(),
            'fecha_aprobacion' => now(),
            'motivo_rechazo' => $request->motivo_rechazo,
        ]);

        // Si la solicitud es aprobada, aplicar los cambios al movimiento
        if ($request->estado === 'aprobada') {
            if ($solicitud->tipo === 'editar') {
                $movimiento->update($solicitud->datos_nuevos);
            } elseif ($solicitud->tipo === 'eliminar') {
                $movimiento->delete();
            }
        }

        return redirect()->route('solicitudes_movimientos.index')
            ->with('success', 'Solicitud procesada exitosamente.');
    }
}