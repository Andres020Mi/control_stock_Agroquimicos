@extends('layouts.master')

@section('title')
    Insumos
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

    .alert-success {
        margin-bottom: 1rem;
        padding: 0.75rem 1.25rem;
        background-color: #d4edda;
        border-left: 4px solid #28a745;
        color: #155724;
        border-radius: 0.25rem;
    }

    .btn-success {
        background-color: #15803d;
        border-color: #15803d;
        color: #fff;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        transition: background-color 0.15s ease-in-out;
    }

    .btn-success:hover {
        background-color: #166534;
        border-color: #166534;
    }

    .btn-warning {
        background-color: #ca8a04;
        border-color: #ca8a04;
        color: #fff;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        transition: background-color 0.15s ease-in-out;
    }

    .btn-warning:hover {
        background-color: #a16207;
        border-color: #a16207;
    }

    .btn-danger {
        background-color: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        transition: background-color 0.15s ease-in-out;
    }

    .btn-danger:hover {
        background-color: #991b1b;
        border-color: #991b1b;
    }

    .dataTables_wrapper .dataTables_length {
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: flex-start; /* Alinea los botones a la izquierda */
    }

    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    img {
        max-height: 4rem;
        width: auto;
        border-radius: 0.25rem;
    }

    .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .actions {
            flex-direction: column;
            align-items: flex-start;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .dataTables_wrapper .dataTables_length {
            display: block;
            width: 100%;
        }
        .dataTables_wrapper .dt-buttons {
            justify-content: flex-start;
            margin-top: 0.5rem;
        }
        .dataTables_wrapper .dataTables_filter {
            justify-content: flex-start;
            margin-top: 0.5rem;
        }
    }
</style>
    <link rel="stylesheet" href="{{ asset('DataTables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('DataTables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Insumos</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-3">
                    <a href="{{ route('insumos.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Crear Nuevo Insumo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="miTabla">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Composición Química</th>
                                <th>Unidad de Medida</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($insumos as $insumo)
                                <tr>
                                    <td>{{ $insumo->id }}</td>
                                    <td>{{ $insumo->nombre }}</td>
                                    <td>{{ $insumo->composicion_quimica }}</td>
                                    <td>{{ $insumo->unidad_de_medida }}</td>
                                    <td>
                                        @if ($insumo->imagen)
                                            <img src="{{ asset('storage/' . $insumo->imagen) }}" alt="{{ $insumo->nombre }}">
                                        @else
                                            <span>Sin imagen</span>
                                        @endif
                                    </td>
                                    <td class="actions">
                                        <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>
                                        <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash mr-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay insumos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script src="{{ asset('DataTables/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('DataTables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('DataTables/jszip.min.js') }}"></script>
    <script src="{{ asset('DataTables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('DataTables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('DataTables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('DataTables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                dom: 'lBfrtip', // 'l' (selector de longitud), 'B' (botones), 'f' (filtro), 'r' (procesamiento), 't' (tabla), 'i' (info), 'p' (paginación)
                lengthChange: true,
                lengthMenu: [10, 25, 50, 100],
                buttons: [
                    { extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar', className: 'btn btn-secondary' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-secondary' },
                    { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-secondary' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-secondary' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir', className: 'btn btn-secondary' }
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron resultados",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "Sin registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [
                    { targets: 4, orderable: false, searchable: false },
                    { targets: 5, orderable: false, searchable: false }
                ]
            });
    
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
    
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres eliminar este insumo? Esto también eliminará los stocks y movimientos asociados.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection