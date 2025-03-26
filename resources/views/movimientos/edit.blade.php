@extends('layouts.app')

@section('header')
    Editar Movimiento
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Editar Movimiento</h1>

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
            <form action="{{ route('movimientos.update', $movimiento->id) }}" method="POST" class="update-form">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Movimiento</label>
                    <select name="tipo" id="tipo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="entrada" {{ old('tipo', $movimiento->tipo) == 'Entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ old('tipo', $movimiento->tipo) == 'Salida' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="id_stock" class="block text-sm font-semibold text-gray-700 mb-2">Stock</label>
                    <select name="id_stock" id="id_stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
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
                </div>

                <!-- Mini tabla para mostrar detalles del stock seleccionado -->
                <div class="mb-6" id="stockDetails">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Detalles del Stock Seleccionado</label>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Insumo</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Cantidad Actual</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Unidad de Medida</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Fecha de Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody id="stockDetailsBody" class="bg-gray-50">
                            <!-- Se llenará dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="mb-6">
                    <label for="cantidad" class="block text-sm font-semibold text-gray-700 mb-2">Cantidad</label>
                    <div class="relative">
                        <input type="number" name="cantidad" id="cantidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-12" value="{{ old('cantidad', $movimiento->cantidad) }}" min="1" required>
                        <span id="unidad_cantidad" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700"></span>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="id_unidad_de_produccion" class="block text-sm font-semibold text-gray-700 mb-2">Unidad de Producción (Opcional, solo para salidas)</label>
                    <select name="id_unidad_de_produccion" id="id_unidad_de_produccion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Ninguna</option>
                        @foreach ($unidades as $unidad)
                            <option value="{{ $unidad->id }}" {{ old('id_unidad_de_produccion', $movimiento->id_unidad_de_produccion) == $unidad->id ? 'selected' : '' }}>
                                {{ $unidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Actualizar
                    </button>
                    <a href="{{ route('movimientos.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 -->
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
                            <td colspan="4" class="px-4 py-2 text-sm text-gray-600 text-center">Seleccione un stock para ver los detalles</td>
                        </tr>
                    `;
                } else {
                    stockDetailsBody.innerHTML = `
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800 border-t border-gray-200">${selectedOption.dataset.insumo}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-t border-gray-200">${selectedOption.dataset.cantidad}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-t border-gray-200">${selectedOption.dataset.unidad}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-t border-gray-200">${selectedOption.dataset.vencimiento}</td>
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