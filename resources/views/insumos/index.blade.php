@extends('layouts.app')

@section('header')
    Insumos
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Listado de Insumos</h1>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded-r-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('insumos.create') }}" class="inline-block px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                Crear Nuevo Insumo
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-300">
            <table class="w-full table-auto" id="miTabla">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Nombre</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Composición Química</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Unidad de Medida</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Imagen</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    @forelse ($insumos as $insumo)
                        <tr class="hover:bg-green-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-800 border-t border-gray-200">{{ $insumo->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-t border-gray-200">{{ $insumo->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-t border-gray-200">{{ $insumo->composicion_quimica }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-t border-gray-200">{{ $insumo->unidad_de_medida }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-t border-gray-200">
                                @if ($insumo->imagen)
                                    <img src="{{ asset('storage/' . $insumo->imagen) }}" alt="{{ $insumo->nombre }}" class="h-16 w-auto rounded-lg shadow">
                                @else
                                    <span class="text-gray-500">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm border-t border-gray-200">
                                <a href="{{ route('insumos.edit', $insumo->id) }}" class="inline-block px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200">
                                    Editar
                                </a>
                                <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 inline-block px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 transition duration-200">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-sm text-gray-600 text-center border-t border-gray-200">
                                No hay insumos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- SweetAlert2 -->
        <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>


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

        <!-- DataTables Initialization -->
        <script>
            $(document).ready(function() {
                $('#miTabla').DataTable({
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
                        }
                    },
                    responsive: true,
                    order: [[0, 'desc']],
                    columnDefs: [
                        { targets: 4, orderable: false, searchable: false },
                        { targets: 5, orderable: false, searchable: false }
                    ]
                });

                // SweetAlert2 para confirmación de eliminación
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
    </div>
@endsection
