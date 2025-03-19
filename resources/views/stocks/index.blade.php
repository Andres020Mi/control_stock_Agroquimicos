@extends('layouts.app')

@section('header')
    Stocks
@endsection

@section('content')
    <div class="container mt-5">
        <h1>Listado de Stocks</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">Crear Nuevo Stock</a>

        <table class="table table-bordered" id="miTabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Insumo</th>
                    <th>Cantidad</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Almacén</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->insumo->nombre }}</td>
                        <td>{{ $stock->cantidad }} {{ $stock->insumo->unidad_de_medida }}</td>
                        <td>{{ $stock->fecha_de_vencimiento }}</td>
                        <td>{{ $stock->almacen->nombre }}</td>
                        <td>{{ $stock->estado }}</td>
                        <td>
                            <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este stock?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay stocks registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- External Resources -->
        <!-- CSS -->
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
                    order: [[0, 'desc']]
                });
            });
        </script>
    </div>
@endsection