@extends('layouts.app')

@section('header')
    Proveedores
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Listado de Proveedores</h1>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded-r-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('proveedores.create') }}" class="inline-block px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                Crear Nuevo Proveedor
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-300">
            <table class="w-full table-auto" id="proveedoresTabla">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Nombre</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">NIT</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Teléfono</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Dirección</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Fecha de Creación</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    <!-- Los datos serán cargados dinámicamente por DataTables -->
                </tbody>
            </table>
        </div>

        <!-- External Resources -->
        <link rel="stylesheet" href="{{ asset('DataTables/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('DataTables/buttons.dataTables.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- JavaScript -->
        <script src="{{ asset('DataTables/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('DataTables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('DataTables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('DataTables/jszip.min.js') }}"></script>
        <script src="{{ asset('DataTables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('DataTables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('DataTables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('DataTables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>

        <!-- DataTables Initialization -->
        <script>
            $(document).ready(function() {
                var table = $('#proveedoresTabla').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('proveedores.index') }}',
                        error: function(xhr, error, thrown) {
                            console.log('Error en la solicitud AJAX:', xhr.responseText);
                            alert('Error al cargar los datos: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'nombre', name: 'nombre' },
                        { data: 'nit', name: 'nit' },
                        { data: 'telefono', name: 'telefono' },
                        { data: 'email', name: 'email' },
                        { data: 'direccion', name: 'direccion' },
                        { data: 'created_at', name: 'created_at' },
                        { 
                            data: 'acciones', 
                            name: 'acciones', 
                            orderable: false, 
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                                    <div class="flex space-x-2">
                                        <a href="{{ url('proveedores/${row.id}/edit') }}" class="px-3 py-1 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition duration-200">
                                            Editar
                                        </a>
                                        <form action="{{ url('proveedores/${row.id}') }}" method="POST" class="inline delete-form">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="px-3 py-1 bg-red-700 text-white text-sm rounded-lg hover:bg-red-800 transition duration-200">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                `;
                            }
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar' },
                        { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV' },
                        { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel' },
                        { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                        { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
                    ],
                    language: {
                        lengthMenu: "Mostrar _MENU_ entradas por página",
                        zeroRecords: "No se encontraron resultados",
                        info: "Página _PAGE_ de _PAGES_",
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
                        { targets: 7, orderable: false, searchable: false, width: '150px' }
                    ]
                });

                // SweetAlert2 para confirmación de eliminación
                $(document).on('click', '.delete-form button', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: '¿Quieres eliminar este proveedor? Esta acción no se puede deshacer.',
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
    </div>
@endsection