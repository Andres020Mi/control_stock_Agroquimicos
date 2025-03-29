<?php

namespace App\Http\Controllers;

use App\Models\SolicitudMovimiento;
use App\Models\Stock;
use App\Models\unidades_de_produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudesMovimientosController extends Controller
{
    public function index(Request $request)
    {
        // Obtener solo las solicitudes pendientes
        $solicitudes = SolicitudMovimiento::with(['user', 'movimiento.stock.insumo', 'movimiento.unidadDeProduccion', 'aprobador'])
            ->where('estado', 'pendiente')
            ->orderBy('id', 'desc')
            ->paginate(10); // Paginación de 10 registros por página

        return view('solicitudes_movimientos.index', compact('solicitudes'));
    }

    public function edit($id)
    {
        $solicitud = SolicitudMovimiento::with([
            'user',
            'movimiento.stock.insumo',
            'movimiento.stock.proveedor', // Añadimos la relación proveedor
            'movimiento.unidadDeProduccion'
        ])->findOrFail($id);

        // Verificar que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'Esta solicitud ya ha sido procesada.');
        }

        // Verificar si el movimiento existe
        if (!$solicitud->movimiento) {
            $solicitud->update([
                'estado' => 'rechazada',
                'aprobador_id' => auth()->id(),
                'fecha_aprobacion' => now(),
                'motivo_rechazo' => 'El movimiento asociado ya no existe.',
            ]);

            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'El movimiento asociado a esta solicitud ya no existe. La solicitud ha sido marcada como rechazada.');
        }

        // Cargar stocks y unidades de producción para mostrar los datos propuestos
        $stocks = Stock::with(['insumo', 'almacen', 'proveedor'])->get(); // Añadimos la relación proveedor
        $unidades = unidades_de_produccion::all();

        return view('solicitudes_movimientos.edit', compact('solicitud', 'stocks', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        $solicitud = SolicitudMovimiento::findOrFail($id);
        $movimiento = $solicitud->movimiento;

        // Verificar que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'Esta solicitud ya ha sido procesada.');
        }

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
                'motivo_rechazo' => 'El movimiento asociado ya no existe.',
            ]);

            return redirect()->route('solicitudes_movimientos.index')
                ->with('error', 'El movimiento asociado a esta solicitud ya no existe. La solicitud ha sido marcada como rechazada.');
        }

        // Validar la solicitud
        $request->validate([
            'estado' => 'required|in:aprobada,rechazada',
            'motivo_rechazo' => 'required_if:estado,rechazada|string|nullable|max:500',
        ], [
            'estado.required' => 'Debes seleccionar un estado para la solicitud.',
            'estado.in' => 'El estado debe ser "aprobada" o "rechazada".',
            'motivo_rechazo.required_if' => 'Debes proporcionar un motivo de rechazo si el estado es "rechazada".',
            'motivo_rechazo.max' => 'El motivo de rechazo no puede exceder los 500 caracteres.',
        ]);

        // Actualizar la solicitud
        $solicitud->estado = $request->estado;
        $solicitud->aprobador_id = auth()->id();
        $solicitud->fecha_aprobacion = now();
        $solicitud->motivo_rechazo = $request->estado === 'rechazada' ? $request->motivo_rechazo : null;

        // Si la solicitud es aprobada, aplicar los cambios al movimiento
        if ($request->estado === 'aprobada') {
            if ($solicitud->tipo === 'editar') {
                // Cargar la relación stock del movimiento original
                $movimiento->load('stock');
                $stockOriginal = $movimiento->stock;

                // Guardar los datos originales del movimiento
                $tipoOriginal = $movimiento->tipo;
                $cantidadOriginal = $movimiento->cantidad;
                $idStockOriginal = $movimiento->id_stock;

                // Obtener los datos nuevos
                $datosNuevos = $solicitud->datos_nuevos;
                $tipoNuevo = $datosNuevos['tipo'] ?? $tipoOriginal;
                $cantidadNueva = $datosNuevos['cantidad'] ?? $cantidadOriginal;
                $idStockNuevo = $datosNuevos['id_stock'] ?? $idStockOriginal;
                $idUnidadProduccionNueva = $datosNuevos['id_unidad_de_produccion'] ?? $movimiento->id_unidad_de_produccion;

                // Validar que la cantidad no deje el stock en negativo si es una salida
                $stockNuevo = Stock::findOrFail($idStockNuevo);
                if ($tipoNuevo === 'salida' && $cantidadNueva > $stockNuevo->cantidad) {
                    $solicitud->update([
                        'estado' => 'rechazada',
                        'motivo_rechazo' => "La cantidad solicitada ($cantidadNueva) excede la cantidad disponible en el stock ($stockNuevo->cantidad).",
                    ]);
                    return redirect()->route('solicitudes_movimientos.index')
                        ->with('error', "No se pudo aprobar la solicitud: la cantidad solicitada ($cantidadNueva) excede la cantidad disponible en el stock ($stockNuevo->cantidad).");
                }

                // Revertir el efecto del movimiento original en el stock
                if ($stockOriginal) {
                    if ($tipoOriginal === 'salida') {
                        $stockOriginal->increment('cantidad', $cantidadOriginal);
                    } elseif ($tipoOriginal === 'entrada') {
                        $stockOriginal->decrement('cantidad', $cantidadOriginal);
                        if ($stockOriginal->cantidad < 0) {
                            $stockOriginal->update(['cantidad' => 0]);
                        }
                    }
                }

                // Actualizar el movimiento con los datos nuevos
                $movimiento->update([
                    'tipo' => $tipoNuevo,
                    'cantidad' => $cantidadNueva,
                    'id_stock' => $idStockNuevo,
                    'id_unidad_de_produccion' => $idUnidadProduccionNueva,
                ]);

                // Cargar el nuevo stock (si cambió el id_stock)
                $stockNuevo = $idStockNuevo === $idStockOriginal ? $stockOriginal : Stock::find($idStockNuevo);

                // Aplicar el efecto del movimiento editado en el stock
                if ($stockNuevo) {
                    if ($tipoNuevo === 'salida') {
                        $stockNuevo->decrement('cantidad', $cantidadNueva);
                        if ($stockNuevo->cantidad < 0) {
                            $stockNuevo->update(['cantidad' => 0]);
                        }
                    } elseif ($tipoNuevo === 'entrada') {
                        $stockNuevo->increment('cantidad', $cantidadNueva);
                    }
                }
            } elseif ($solicitud->tipo === 'eliminar') {
                $movimiento->load('stock');

                if ($movimiento->stock) {
                    if ($movimiento->tipo === 'salida') {
                        $movimiento->stock->increment('cantidad', $movimiento->cantidad);
                    } elseif ($movimiento->tipo === 'entrada') {
                        $movimiento->stock->decrement('cantidad', $movimiento->cantidad);
                        if ($movimiento->stock->cantidad < 0) {
                            $movimiento->stock->update(['cantidad' => 0]);
                        }
                    }
                }

                $movimiento->delete();
            }
        }

        $solicitud->save();

        return redirect()->route('solicitudes_movimientos.index')
            ->with('success', 'Solicitud procesada exitosamente.');
    }

    // Método para ver las solicitudes revisadas (aprobadas o rechazadas)
    public function revisadas(Request $request)
    {
        $solicitudes = SolicitudMovimiento::with(['user', 'movimiento.stock.insumo', 'movimiento.unidadDeProduccion', 'aprobador'])
            ->whereIn('estado', ['aprobada', 'rechazada', 'cancelada'])
            ->orderBy('id', 'desc')
            ->paginate(10); // Paginación de 10 registros por página

        return view('solicitudes_movimientos.revisadas', compact('solicitudes'));
    }

    // Método para que los líderes vean sus solicitudes
    public function misSolicitudes(Request $request)
    {
        $user = Auth::user();

        // Obtener todas las solicitudes del usuario autenticado
        $solicitudes = SolicitudMovimiento::with(['user', 'movimiento.stock.insumo', 'movimiento.unidadDeProduccion', 'aprobador'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('solicitudes_movimientos.mis_solicitudes', compact('solicitudes'));
    }

    // Método para cancelar una solicitud pendiente
    public function cancelar($id)
    {
        $user = Auth::user();
        $solicitud = SolicitudMovimiento::findOrFail($id);

        // Verificar que el usuario sea líder de unidad
        if ($user->role !== 'lider de la unidad') {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // Verificar que la solicitud pertenece al usuario
        if ($solicitud->user_id !== $user->id) {
            abort(403, 'No tienes permisos para cancelar esta solicitud.');
        }

        // Verificar que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('solicitudes_movimientos.mis_solicitudes')
                ->with('error', 'Solo puedes cancelar solicitudes pendientes.');
        }

        // Actualizar el estado de la solicitud a "cancelada"
        $solicitud->update([
            'estado' => 'cancelada',
            'fecha_aprobacion' => now(),
            'motivo_rechazo' => 'Cancelada por el usuario.',
        ]);

        return redirect()->route('solicitudes_movimientos.mis_solicitudes')
            ->with('success', 'Solicitud cancelada exitosamente.');
    }
}