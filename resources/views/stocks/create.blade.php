@extends('layouts.app')

@section('header')
    Crear Stock de Agroquímicos
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Crear Nuevo Stock</h1>

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
            <form action="{{ route('stocks.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="id_insumo" class="block text-sm font-semibold text-gray-700 mb-2">Insumo</label>
                    <select name="id_insumo" id="id_insumo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccione un insumo</option>
                        @foreach ($insumos as $insumo)
                            <option value="{{ $insumo->id }}" {{ old('id_insumo') == $insumo->id ? 'selected' : '' }}>
                                {{ $insumo->nombre }} ({{ $insumo->unidad_de_medida }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="cantidad" class="block text-sm font-semibold text-gray-700 mb-2">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('cantidad') }}" min="1" required>
                </div>

                <div class="mb-6">
                    <label for="fecha_de_vencimiento" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('fecha_de_vencimiento') }}" required>
                </div>

                <div class="mb-6">
                    <label for="id_almacen" class="block text-sm font-semibold text-gray-700 mb-2">Almacén</label>
                    <select name="id_almacen" id="id_almacen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccione un almacén</option>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ old('id_almacen') == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Guardar
                    </button>
                    <a href="{{ route('stocks.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection