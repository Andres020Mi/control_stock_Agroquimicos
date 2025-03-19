@extends('layouts.app')

@section('header')
    Crear Insumo
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Crear Nuevo Insumo</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-lg shadow-md">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('insumos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-4">
                <label for="composicion_quimica" class="block text-sm font-semibold text-gray-700">Composición Química</label>
                <input type="text" name="composicion_quimica" id="composicion_quimica" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" value="{{ old('composicion_quimica') }}" required>
            </div>

            <div class="mb-4">
                <label for="unidad_de_medida" class="block text-sm font-semibold text-gray-700">Unidad de Medida</label>
                <select name="unidad_de_medida" id="unidad_de_medida" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" required>
                    <option value="kg" {{ old('unidad_de_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                    <option value="g" {{ old('unidad_de_medida') == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                    <option value="l" {{ old('unidad_de_medida') == 'l' ? 'selected' : '' }}>Litros (l)</option>
                    <option value="ml" {{ old('unidad_de_medida') == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="imagen" class="block text-sm font-semibold text-gray-700">Imagen (Opcional)</label>
                <input type="file" name="imagen" id="imagen" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" accept="image/*">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                    Guardar
                </button>
                <a href="{{ route('insumos.index') }}" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700 transition duration-200">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
