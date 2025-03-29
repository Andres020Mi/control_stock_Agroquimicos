@extends('layouts.master')

@section('title')
    Revisar Solicitud de Movimiento
@endsection

@section('links_css_head')
    <style>
        /* Estilos ajustados para compatibilidad con AdminLTE y responsividad */
        .content-wrapper {
            padding: 20px;
        }

        .card {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
        }

        .card-header {
            background-color: #15803d;
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
        }

        .card-body {
            padding: 1.25rem;
        }

        .alert-danger {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
            border-radius: 0.25rem;
        }

        .btn-success {
            background-color: #15803d;
            border-color: #15803d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            min-width: 150px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-success:hover {
            background-color: #166534;
            border-color: #166534;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            min-width: 150px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        select, textarea {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        select:focus, textarea:focus {
            border-color: #15803d;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25);
        }

        .error-border {
            border-color: #dc3545 !important;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Estilos para las tablas */
        .data-table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .data-table th, .data-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }

        .data-table th {
            background-color: #e9ecef;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
        }

        .data-table td {
            font-size: 0.875rem;
            color: #212529;
        }

        /* Resaltar fechas de caducidad próximas o caducadas */
        .text-warning {
            color: #990000;
        }

        .text-danger {
            color: #b7a22c;
        }

        /* Estilos para el formulario */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group i {
            position: absolute;
            left: 10px;
            top: 38px;
            color: #6c757d;
        }

        .form-group select, .form-group textarea {
            padding-left: 2rem;
        }

        @media (max-width: 768px) {
            .data-table th, .data-table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            .data-table th {
                background-color: #e9ecef;
            }

            .data-table td {
                border-top: none;
            }

            .btn-success, .btn-secondary {
                min-width: 120px;
                padding: 0.3rem 0.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Revisar Solicitud de Movimiento: #{{ $solicitud->id }}</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Mostrar información de la solicitud -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Detalles de la Solicitud</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Solicitante</th>
                                <th>Tipo de Solicitud</th>
                                <th>Estado Actual</th>
                                <th>Fecha de Solicitud</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $solicitud->user ? $solicitud->user->name : 'Usuario no encontrado' }}</td>
                                <td>{{ ucfirst($solicitud->tipo) }}</td>
                                <td>{{ ucfirst($solicitud->estado) }}</td>
                                <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mostrar datos actuales del movimiento -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Datos Actuales del Movimiento</h2>
                    @if ($solicitud->movimiento)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID Movimiento</th>
                                    <th>Tipo</th>
                                    <th>Stock Asociado</th>
                                    <th>Cantidad</th>
                                    <th>Unidad de Producción</th>
                                    <th>Fecha de Caducidad</th>
                                    <th>Proveedor</th>
                                    <th>Estado del Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $solicitud->movimiento->id }}</td>
                                    <td>{{ ucfirst($solicitud->movimiento->tipo) }}</td>
                                    <td>
                                        {{ $solicitud->movimiento->stock ? $solicitud->movimiento->stock->id . ' (' . $solicitud->movimiento->stock->insumo->nombre . ' - ' . $solicitud->movimiento->stock->almacen->nombre . ')' : 'Stock no encontrado' }}
                                    </td>
                                    <td>
                                        {{ $solicitud->movimiento->cantidad }} {{ $solicitud->movimiento->stock && $solicitud->movimiento->stock->insumo ? $solicitud->movimiento->stock->insumo->unidad_de_medida : '' }}
                                    </td>
                                    <td>
                                        {{ $solicitud->movimiento->unidadDeProduccion ? $solicitud->movimiento->unidadDeProduccion->nombre : 'No asignada' }}
                                    </td>
                                    <td>
                                        @if ($solicitud->movimiento->stock && $solicitud->movimiento->stock->fecha_de_vencimiento)
                                            @php
                                                $fechaVencimiento = $solicitud->movimiento->stock->fecha_de_vencimiento;
                                                $hoy = now();
                                                $diasRestantes = $hoy->diffInDays($fechaVencimiento, false);
                                            @endphp
                                            <span class="{{ $diasRestantes < 0 ? 'text-danger' : ($diasRestantes <= 30 ? 'text-warning' : '') }}">
                                                {{ $fechaVencimiento->format('d/m/Y') }}
                                                @if ($diasRestantes < 0)
                                                    (Caducado)
                                                @elseif ($diasRestantes <= 30)
                                                    (Próximo a caducar: {{ $diasRestantes }} días)
                                                @endif
                                            </span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{ $solicitud->movimiento->stock && $solicitud->movimiento->stock->proveedor ? $solicitud->movimiento->stock->proveedor->nombre : 'Sin proveedor' }}
                                    </td>
                                    <td>
                                        {{ $solicitud->movimiento->stock ? ucfirst($solicitud->movimiento->stock->estado) : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600">Movimiento no encontrado.</p>
                    @endif
                </div>

                <!-- Mostrar datos nuevos propuestos (si es una solicitud de edición) -->
                @if ($solicitud->tipo === 'editar' && $solicitud->datos_nuevos)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Datos Nuevos Propuestos</h2>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Valor Propuesto</th>
                                    @if (isset($solicitud->datos_nuevos['id_stock']))
                                        <th>Fecha de Caducidad</th>
                                        <th>Proveedor</th>
                                        <th>Estado del Stock</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($solicitud->datos_nuevos['tipo']))
                                    <tr>
                                        <td>Tipo de Movimiento</td>
                                        <td>{{ ucfirst($solicitud->datos_nuevos['tipo']) }}</td>
                                        @if (isset($solicitud->datos_nuevos['id_stock']))
                                            <td colspan="3"></td>
                                        @endif
                                    </tr>
                                @endif
                                @if (isset($solicitud->datos_nuevos['id_stock']))
                                    <tr>
                                        <td>Stock Asociado</td>
                                        <td>
                                            @php
                                                $stock = $stocks->firstWhere('id', $solicitud->datos_nuevos['id_stock']);
                                            @endphp
                                            {{ $stock ? $stock->id . ' (' . $stock->insumo->nombre . ' - ' . $stock->almacen->nombre . ')' : 'Stock no encontrado' }}
                                        </td>
                                        <td>
                                            @if ($stock && $stock->fecha_de_vencimiento)
                                                @php
                                                    $fechaVencimiento = $stock->fecha_de_vencimiento;
                                                    $hoy = now();
                                                    $diasRestantes = $hoy->diffInDays($fechaVencimiento, false);
                                                @endphp
                                                <span class="{{ $diasRestantes < 0 ? 'text-danger' : ($diasRestantes <= 30 ? 'text-warning' : '') }}">
                                                    {{ $fechaVencimiento->format('d/m/Y') }}
                                                    @if ($diasRestantes < 0)
                                                        (Caducado)
                                                    @elseif ($diasRestantes <= 30)
                                                        (Próximo a caducar: {{ $diasRestantes }} días)
                                                    @endif
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            {{ $stock && $stock->proveedor ? $stock->proveedor->nombre : 'Sin proveedor' }}
                                        </td>
                                        <td>
                                            {{ $stock ? ucfirst($stock->estado) : 'N/A' }}
                                        </td>
                                    </tr>
                                @endif
                                @if (isset($solicitud->datos_nuevos['cantidad']))
                                    <tr>
                                        <td>Cantidad</td>
                                        <td>
                                            {{ $solicitud->datos_nuevos['cantidad'] }} 
                                            @if (isset($solicitud->datos_nuevos['id_stock']))
                                                @php
                                                    $stock = $stocks->firstWhere('id', $solicitud->datos_nuevos['id_stock']);
                                                @endphp
                                                {{ $stock && $stock->insumo ? $stock->insumo->unidad_de_medida : '' }}
                                            @else
                                                {{ $solicitud->movimiento->stock && $solicitud->movimiento->stock->insumo ? $solicitud->movimiento->stock->insumo->unidad_de_medida : '' }}
                                            @endif
                                        </td>
                                        @if (isset($solicitud->datos_nuevos['id_stock']))
                                            <td colspan="3"></td>
                                        @endif
                                    </tr>
                                @endif
                                @if (isset($solicitud->datos_nuevos['id_unidad_de_produccion']))
                                    <tr>
                                        <td>Unidad de Producción</td>
                                        <td>
                                            @php
                                                $unidad = $unidades->firstWhere('id', $solicitud->datos_nuevos['id_unidad_de_produccion']);
                                            @endphp
                                            {{ $unidad ? $unidad->nombre : 'No asignada' }}
                                        </td>
                                        @if (isset($solicitud->datos_nuevos['id_stock']))
                                            <td colspan="3"></td>
                                        @endif
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Formulario para aprobar o rechazar -->
                <form action="{{ route('solicitudes_movimientos.update', $solicitud->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="estado">Acción</label>
                        <i class="fas fa-check-circle"></i>
                        <select name="estado" id="estado" class="@error('estado') error-border @enderror">
                            <option value="">Seleccione una acción</option>
                            <option value="aprobada">Aprobar</option>
                            <option value="rechazada">Rechazar</option>
                        </select>
                        @error('estado')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" id="motivo-rechazo-container" style="display: none;">
                        <label for="motivo_rechazo">Motivo de Rechazo (requerido si se rechaza)</label>
                        <i class="fas fa-comment-alt"></i>
                        <textarea name="motivo_rechazo" id="motivo_rechazo" class="@error('motivo_rechazo') error-border @enderror">{{ old('motivo_rechazo') }}</textarea>
                        @error('motivo_rechazo')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('solicitudes_movimientos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Procesar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script>
        document.getElementById('estado').addEventListener('change', function () {
            const motivoRechazoContainer = document.getElementById('motivo-rechazo-container');
            if (this.value === 'rechazada') {
                motivoRechazoContainer.style.display = 'block';
            } else {
                motivoRechazoContainer.style.display = 'none';
            }
        });
    </script>
@endsection