@extends('layouts.master')

@section('title')
    Solicitudes de Movimientos Revisadas
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

        .alert-success {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
            border-radius: 0.25rem;
        }

        .alert-danger {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
            border-radius: 0.25rem;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table thead th {
            background-color: #15803d;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
            background-color: #fff;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .pagination {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            color: #15803d;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
        }

        .pagination .page-item.active .page-link {
            background-color: #15803d;
            border-color: #15803d;
            color: #fff;
        }

        .pagination .page-item .page-link:hover {
            background-color: #e9ecef;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .flex {
                flex-direction: column;
                align-items: flex-start;
            }

            .space-x-4 > :not(:last-child) {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Solicitudes de Movimientos Revisadas</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('solicitudes_movimientos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver a Solicitudes Pendientes
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Movimiento</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Aprobador</th>
                                <th>Fecha de Aprobación</th>
                                <th>Motivo de Rechazo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($solicitudes as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->id }}</td>
                                    <td>
                                        {{ $solicitud->user ? $solicitud->user->name : 'Usuario no encontrado' }}
                                    </td>
                                    <td>
                                        {{ $solicitud->movimiento ? $solicitud->movimiento->id . ' (' . $solicitud->movimiento->tipo . ')' : 'Movimiento no encontrado' }}
                                    </td>
                                    <td>{{ $solicitud->tipo }}</td>
                                    <td>{{ $solicitud->estado }}</td>
                                    <td>
                                        {{ $solicitud->aprobador ? $solicitud->aprobador->name : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $solicitud->fecha_aprobacion ? $solicitud->fecha_aprobacion->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $solicitud->motivo_rechazo ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No hay solicitudes revisadas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Enlaces de paginación -->
                <div class="pagination">
                    {{ $solicitudes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection