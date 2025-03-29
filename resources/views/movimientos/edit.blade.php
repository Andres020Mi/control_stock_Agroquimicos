@extends('layouts.master')

@section('title')
    Editar Movimiento
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

        select, input[type="number"] {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        select:focus, input[type="number"]:focus {
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

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .inset-y-0 {
            top: 0;
            bottom: 0;
        }

        .right-0 {
            right: 0;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .text-gray-700 {
            color: #495057;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Movimiento</h3>
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

                <form action="{{ route('movimientos.update', $movimiento->id) }}" method="POST" class="update-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="tipo">Tipo de Movimiento</label>
                        <select name="tipo" id="tipo" class="@error('tipo') error-border @enderror" required>
                            <option value="entrada" {{ old('tipo', $movimiento->tipo) == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="salida" {{ old('tipo', $movimiento->tipo) == 'salida' ? 'selected' : '' }}>Salida</option>
                        </select>
                        @error('tipo')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_stock">Stock</label>
                        <select name="id_stock" id="id_stock" class="@error('id_stock') error-border @enderror" required>
                            @foreach ($stocks as $stock)
                                <option value="{{ $stock->id }}" 
                                        data-cantidad="{{ $stock->cantidad }}" 
                                        data-insumo="{{ $stock->insumo->nombre }}" 
                                        data-unidad="{{ $stock->insumo->unidad_de_medida }}" 
                                        data-vencimiento="{{ $stock->fecha_de_vencimiento }}"
                                        {{ old('id_stock', $movimiento->id_stock) == $stock->id ? 'selected' : '' }}>
                                    {{ $stock->insumo->nombre }} ({{ $stock->cantidad }} {{ $stock->insumo->unidad_de_medida }}) - Almacén: {{ $stock->almacen->nombre }} - Vence: {{ $stock->fecha_de_vencimiento }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_stock')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mini tabla para mostrar detalles del stock seleccionado -->
                    <div class="mb-4">
                        <label>Detalles del Stock Seleccionado</label>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Insumo</th>
                                        <th>Cantidad Actual</th>
                                        <th>Unidad de Medida</th>
                                        <th>Fecha de Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody id="stockDetailsBody">
                                    <!-- Se llenará dinámicamente con JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="cantidad">Cantidad</label>
                        <div class="relative">
                            <input type="number" name="cantidad" id="cantidad" class="@error('cantidad') error-border @enderror" value="{{ old('cantidad', $movimiento->cantidad) }}" min="1" required>
                            <span id="unidad_cantidad" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700"></span>
                        </div>
                        @error('cantidad')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_unidad_de_produccion">Unidad de Producción (Opcional, solo para salidas)</label>
                        <select name="id_unidad_de_produccion" id="id_unidad_de_produccion" class="@error('id_unidad_de_produccion') error-border @enderror">
                            <option value="">Ninguna</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}" {{ old('id_unidad_de_produccion', $movimiento->id_unidad_de_produccion) == $unidad->id ? 'selected' : '' }}>
                                    {{ $unidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_unidad_de_produccion')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Actualizar
                        </button>
                        <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipoSelect = document.getElementById('tipo');
            const stockSelect = document.getElementById('id_stock');
            const unidadCantidadSpan = document.getElementById('unidad_cantidad');
            const stockDetailsBody = document.getElementById('stockDetailsBody');

            function updateFormState() {
                const selectedOption = stockSelect.options[stockSelect.selectedIndex];
                const unidad = selectedOption ? selectedOption.dataset.unidad : '';
                unidadCantidadSpan.textContent = unidad;
                updateStockDetails();
            }

            function updateStockDetails() {
                const selectedOption = stockSelect.options[stockSelect.selectedIndex];
                if (!selectedOption || !selectedOption.dataset.insumo) {
                    stockDetailsBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center">Seleccione un stock para ver los detalles</td>
                        </tr>
                    `;
                } else {
                    stockDetailsBody.innerHTML = `
                        <tr>
                            <td>${selectedOption.dataset.insumo}</td>
                            <td>${selectedOption.dataset.cantidad}</td>
                            <td>${selectedOption.dataset.unidad}</td>
                            <td>${selectedOption.dataset.vencimiento}</td>
                        </tr>
                    `;
                }
            }

            stockSelect.addEventListener('change', updateFormState);
            updateFormState(); // Llamar al cargar la página para mostrar los datos iniciales

            document.querySelector('.update-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres actualizar los datos de este movimiento?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, actualizar',
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