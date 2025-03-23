@extends('layouts.app')

@section('header')
    Editar Stock
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Editar Stock</h1>

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
            <form action="{{ route('stocks.update', $stock->id) }}" method="POST" class="update-form">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="id_insumo" class="block text-sm font-semibold text-gray-700 mb-2">Insumo (No editable)</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $stock->insumo->nombre }}" disabled>
                    <input type="hidden" name="id_insumo" value="{{ $stock->id_insumo }}">
                </div>

                <div class="mb-6">
                    <label for="cantidad" class="block text-sm font-semibold text-gray-700 mb-2">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('cantidad', $stock->cantidad) }}" min="0" required>
                </div>

                <div class="mb-6">
                    <label for="fecha_de_vencimiento" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('fecha_de_vencimiento', $stock->fecha_de_vencimiento) }}" required>
                </div>

                <div class="mb-6">
                    <label for="id_almacen" class="block text-sm font-semibold text-gray-700 mb-2">Almacén</label>
                    <select name="id_almacen" id="id_almacen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ old('id_almacen', $stock->id_almacen) == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="id_proveedor" class="block text-sm font-semibold text-gray-700 mb-2">Proveedor (Opcional)</label>
                    <select name="id_proveedor" id="id_proveedor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Sin proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ old('id_proveedor', $stock->id_proveedor) == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="estado" class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                    <select name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="utilizable" {{ old('estado', $stock->estado) == 'utilizable' ? 'selected' : '' }}>Utilizable</option>
                        <option value="caducado" {{ old('estado', $stock->estado) == 'caducado' ? 'selected' : '' }}>Caducado</option>
                        <option value="agotado" {{ old('estado', $stock->estado) == 'agotado' ? 'selected' : '' }}>Agotado</option> <!-- Agregado -->
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Actualizar
                    </button>
                    <a href="{{ route('stocks.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>

    <script>
        document.querySelector('.update-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres actualizar los datos de este stock?',
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
    </script>
@endsection