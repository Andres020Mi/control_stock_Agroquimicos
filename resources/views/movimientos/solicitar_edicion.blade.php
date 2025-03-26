@extends('layouts.app')

@section('header')
    Solicitar Edición de Movimiento
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Solicitar Edición de Movimiento</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-lg shadow-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('movimientos.solicitar_edicion', $movimiento->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            <div class="mb-4">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" id="tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('tipo') border-red-500 @enderror">
                    <option value="entrada" {{ old('tipo', $movimiento->tipo) == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ old('tipo', $movimiento->tipo) == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
                @error('tipo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="id_stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <select name="id_stock" id="id_stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('id_stock') border-red-500 @enderror">
                    @foreach ($stocks as $stock)
                        <option value="{{ $stock->id }}" {{ old('id_stock', $movimiento->id_stock) == $stock->id ? 'selected' : '' }}>
                            {{ $stock->insumo->nombre }} (Almacén: {{ $stock->almacen->nombre }})
                        </option>
                    @endforeach
                </select>
                @error('id_stock')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', $movimiento->cantidad) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('cantidad') border-red-500 @enderror">
                @error('cantidad')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="id_unidad_de_produccion" class="block text-sm font-medium text-gray-700">Unidad de Producción (opcional)</label>
                <select name="id_unidad_de_produccion" id="id_unidad_de_produccion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('id_unidad_de_produccion') border-red-500 @enderror">
                    <option value="">Ninguna</option>
                    @foreach ($unidades as $unidad)
                        <option value="{{ $unidad->id }}" {{ old('id_unidad_de_produccion', $movimiento->id_unidad_de_produccion) == $unidad->id ? 'selected' : '' }}>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
                @error('id_unidad_de_produccion')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                    Enviar Solicitud
                </button>
            </div>
        </form>
    </div>
@endsection