@extends('layouts.master')

@section('title')
    Líderes de Unidades
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
                <h3 class="card-title">Listado de Líderes de Unidades</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-3">
                    <a href="{{ route('lideres_unidades.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Asignar Líder a Unidad
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="miTabla">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Unidades Asignadas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos serán cargados dinámicamente por DataTables -->
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
            var table = $('#miTabla').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('lideres_unidades.index') }}',
                    error: function(xhr, error, thrown) {
                        console.log('Error en la solicitud AJAX:', xhr.responseText);
                        alert('Error al cargar los datos: ' + xhr.status + ' ' + xhr.statusText);
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'unidades', name: 'unidades' },
                    { 
                        data: null, 
                        name: 'acciones', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            var editUrl = "{{ url('lideres-unidades') }}/" + row.id + "/edit";
                            return `
                                <div class="actions">
                                    <a href="${editUrl}" class="btn btn-warning">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                    </a>
                                </div>
                            `;
                        }
                    }
                ],
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
                    },
                    processing: "Procesando..."
                },
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [
                    { targets: 4, orderable: false, searchable: false, width: '150px' }
                ]
            });
        });
    </script>
@endsection