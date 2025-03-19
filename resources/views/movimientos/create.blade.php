@extends('layouts.app')

@section('header')
    Crear Movimiento
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Crear Nuevo Movimiento</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-lg shadow-md">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-300">
            <form action="{{ route('movimientos.store') }}" method="POST" id="movimientoForm">
                @csrf

                <div class="mb-6">
                    <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Movimiento</label>
                    <select name="tipo" id="tipo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="id_stock" class="block text-sm font-semibold text-gray-700 mb-2">Stock</label>
                    <select name="id_stock" id="id_stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccione un stock</option>
                        @foreach ($stocks as $stock)
                            <option value="{{ $stock->id }}" data-cantidad="{{ $stock->cantidad }}" {{ old('id_stock') == $stock->id ? 'selected' : '' }}>
                                {{ $stock->insumo->nombre }} ({{ $stock->cantidad }} {{ $stock->insumo->unidad_de_medida }}) - Almacén: {{ $stock->almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6" id="unidadesContainer">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Asignar a Unidades de Producción (Opcional, solo para salidas)</label>
                    <div id="unidadesList"></div>
                    <button type="button" id="addUnidad" class="mt-2 px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200" disabled>Agregar Unidad</button>
                </div>

                <div class="mb-6">
                    <label for="cantidad_total" class="block text-sm font-semibold text-gray-700 mb-2">Cantidad Total</label>
                    <input type="number" id="cantidad_total" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Guardar
                    </button>
                    <a href="{{ route('movimientos.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- JavaScript para manejo dinámico -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tipoSelect = document.getElementById('tipo');
                const stockSelect = document.getElementById('id_stock');
                const addUnidadBtn = document.getElementById('addUnidad');
                const unidadesList = document.getElementById('unidadesList');
                const cantidadTotalInput = document.getElementById('cantidad_total');
                let unidadesData = @json($unidades);

                function updateFormState() {
                    const tipo = tipoSelect.value;
                    const stockSelected = stockSelect.value !== '';
                    addUnidadBtn.disabled = !(tipo === 'salida' && stockSelected);
                    if (tipo !== 'salida') unidadesList.innerHTML = '';
                    updateCantidadTotal();
                }

                function updateCantidadTotal() {
                    const cantidades = document.querySelectorAll('.cantidad-unidad');
                    let total = 0;
                    cantidades.forEach(input => total += parseInt(input.value) || 0);
                    cantidadTotalInput.value = total;

                    const selectedOption = stockSelect.options[stockSelect.selectedIndex];
                    const stockDisponible = parseInt(selectedOption.dataset.cantidad);
                    if (tipoSelect.value === 'salida' && total > stockDisponible) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'La cantidad total excede el stock disponible (' + stockDisponible + ').',
                        });
                    }
                }

                addUnidadBtn.addEventListener('click', function () {
                    const row = document.createElement('div');
                    row.className = 'flex space-x-4 mb-2';
                    row.innerHTML = `
                        <div class="flex-1">
                            <select name="unidades[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                                <option value="">Seleccione una unidad</option>
                                ${unidadesData.map(unidad => 
                                    `<option value="${unidad.id}">${unidad.nombre}</option>`
                                ).join('')}
                            </select>
                        </div>
                        <div class="w-1/4">
                            <input type="number" name="cantidades[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg cantidad-unidad focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" min="1" required>
                        </div>
                        <div class="w-1/6">
                            <button type="button" class="w-full px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 transition duration-200 remove-unidad">Eliminar</button>
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

        <!-- SweetAlert2 -->
        <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>

    </div>
@endsection