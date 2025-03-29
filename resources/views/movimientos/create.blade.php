@extends('layouts.master')

@section('title')
    Crear Movimiento
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

        input[type="number"][readonly] {
            background-color: #e9ecef;
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

        .space-x-4 > :not(:last-child) {
            margin-right: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .flex-1 {
            flex: 1;
        }

        .w-1\/4 {
            width: 25%;
        }

        .w-1\/6 {
            width: 16.666667%;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .flex {
                flex-direction: column;
            }

            .space-x-4 > :not(:last-child) {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }

            .w-1\/4, .w-1\/6 {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Nuevo Movimiento</h3>
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

                <form action="{{ route('movimientos.store') }}" method="POST" id="movimientoForm">
                    @csrf

                    <div class="mb-4">
                        <label for="tipo">Tipo de Movimiento</label>
                        <select name="tipo" id="tipo" class="@error('tipo') error-border @enderror" required>
                            <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                        </select>
                        @error('tipo')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_stock">Stock</label>
                        <select name="id_stock" id="id_stock" class="@error('id_stock') error-border @enderror" required>
                            <option value="">Seleccione un stock</option>
                            @foreach ($stocks as $stock)
                                <option value="{{ $stock->id }}" 
                                        data-cantidad="{{ $stock->cantidad }}" 
                                        data-insumo="{{ $stock->insumo->nombre }}" 
                                        data-unidad="{{ $stock->insumo->unidad_de_medida }}" 
                                        data-vencimiento="{{ $stock->fecha_de_vencimiento }}"
                                        {{ old('id_stock') == $stock->id ? 'selected' : '' }}>
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
                                    <tr>
                                        <td colspan="4" class="text-center">Seleccione un stock para ver los detalles</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4" id="unidadesContainer">
                        <label>Asignar a Unidades de Producción (Opcional, solo para salidas)</label>
                        <div id="unidadesList"></div>
                        <button type="button" id="addUnidad" class="mt-2 btn btn-secondary" disabled>
                            <i class="fas fa-plus mr-1"></i> Agregar Unidad
                        </button>
                    </div>

                    <div class="mb-4">
                        <label for="cantidad_total">Cantidad Total</label>
                        <div class="relative">
                            <input type="number" id="cantidad_total" class="bg-gray-100" readonly>
                            <span id="unidad_total" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700"></span>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Guardar
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
            const addUnidadBtn = document.getElementById('addUnidad');
            const unidadesList = document.getElementById('unidadesList');
            const cantidadTotalInput = document.getElementById('cantidad_total');
            const unidadTotalSpan = document.getElementById('unidad_total');
            const stockDetailsBody = document.getElementById('stockDetailsBody');
            let unidadesData = @json($unidades);

            function updateFormState() {
                const tipo = tipoSelect.value;
                const stockSelected = stockSelect.value !== '';
                addUnidadBtn.disabled = !(tipo === 'salida' && stockSelected);
                if (tipo !== 'salida') unidadesList.innerHTML = '';
                updateStockDetails();
                updateCantidadTotal();
            }

            function updateStockDetails() {
                const selectedOption = stockSelect.options[stockSelect.selectedIndex];
                if (stockSelect.value === '') {
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

            function updateCantidadTotal() {
                const cantidades = document.querySelectorAll('.cantidad-unidad');
                let total = 0;
                cantidades.forEach(input => total += parseInt(input.value) || 0);
                const selectedOption = stockSelect.options[stockSelect.selectedIndex];
                const unidad = stockSelect.value ? selectedOption.dataset.unidad : '';
                cantidadTotalInput.value = total;
                unidadTotalSpan.textContent = unidad;

                const stockDisponible = parseInt(selectedOption.dataset.cantidad) || 0;
                if (tipoSelect.value === 'salida' && total > stockDisponible) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La cantidad total excede el stock disponible (' + stockDisponible + ').',
                    });
                }
            }

            addUnidadBtn.addEventListener('click', function () {
                const selectedOption = stockSelect.options[stockSelect.selectedIndex];
                const unidadMedida = selectedOption.dataset.unidad || '';
                const row = document.createElement('div');
                row.className = 'flex space-x-4 mb-2';
                row.innerHTML = `
                    <div class="flex-1">
                        <select name="unidades[]" class="w-full" required>
                            <option value="">Seleccione una unidad</option>
                            ${unidadesData.map(unidad => 
                                `<option value="${unidad.id}">${unidad.nombre}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="w-1/4 relative">
                        <input type="number" name="cantidades[]" class="w-full cantidad-unidad pr-12" min="1" required>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700">${unidadMedida}</span>
                    </div>
                    <div class="w-1/6">
                        <button type="button" class="w-full btn btn-danger remove-unidad">
                            <i class="fas fa-trash mr-1"></i> Eliminar
                        </button>
                    </div>
                `;
                unidadesList.appendChild(row);

                row.querySelector('.cantidad-unidad').addEventListener('input', updateCantidadTotal);
                row.querySelector('.remove-unidad').addEventListener('click', function () {
                    row.remove();
                    updateCantidadTotal();
                });
            });

            tipoSelect.addEventListener('change', updateFormState);
            stockSelect.addEventListener('change', updateFormState);

            updateFormState();
        });
    </script>
@endsection