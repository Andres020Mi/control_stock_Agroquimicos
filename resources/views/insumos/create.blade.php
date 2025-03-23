@extends('layouts.app')

@section('header')
    Crear Insumo
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Crear Nuevo Insumo</h1>

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
            <form action="{{ route('insumos.store') }}" method="POST" enctype="multipart/form-data" id="insumoForm">
                @csrf

                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('nombre') }}" required>
                </div>

                <div class="mb-6">
                    <label for="composicion_quimica" class="block text-sm font-semibold text-gray-700 mb-2">Composición Química</label>
                    <input type="text" name="composicion_quimica" id="composicion_quimica" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('composicion_quimica') }}" required>
                </div>

                <div class="mb-6">
                    <label for="unidad_de_medida" class="block text-sm font-semibold text-gray-700 mb-2">Unidad de Medida</label>
                    <select name="unidad_de_medida" id="unidad_de_medida" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="kg" {{ old('unidad_de_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                        <option value="g" {{ old('unidad_de_medida') == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                        <option value="l" {{ old('unidad_de_medida') == 'l' ? 'selected' : '' }}>Litros (l)</option>
                        <option value="ml" {{ old('unidad_de_medida') == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="imagen" class="block text-sm font-semibold text-gray-700 mb-2">Imagen (Opcional)</label>
                    <input type="file" name="imagen" id="imagen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" accept="image/*">
                    <div id="imagePreview" class="mt-4">
                        <img id="preview" class="max-w-xs hidden rounded-lg shadow-md" alt="Previsualización de la imagen">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Guardar
                    </button>
                    <a href="{{ route('insumos.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript para previsualización de imagen -->
    <script>
        document.getElementById('imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
                preview.src = '';
            }
        });
    </script>
@endsection