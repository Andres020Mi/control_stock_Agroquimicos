@extends('layouts.app')

@section('header')
    Editar Insumo
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Editar Insumo</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-lg shadow-md">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
            <form id="update-form" action="{{ route('insumos.update', $insumo->id) }}" method="POST" enctype="multipart/form-data" class="update-form">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" value="{{ old('nombre', $insumo->nombre) }}" required>
                </div>

                <div class="mb-4">
                    <label for="composicion_quimica" class="block text-sm font-semibold text-gray-700">Composición Química</label>
                    <input type="text" name="composicion_quimica" id="composicion_quimica" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" value="{{ old('composicion_quimica', $insumo->composicion_quimica) }}" required>
                </div>

                <div class="mb-4">
                    <label for="unidad_de_medida" class="block text-sm font-semibold text-gray-700">Unidad de Medida</label>
                    <select name="unidad_de_medida" id="unidad_de_medida" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" required>
                        <option value="kg" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="g" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'g' ? 'selected' : '' }}>g</option>
                        <option value="l" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'l' ? 'selected' : '' }}>l</option>
                        <option value="ml" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'ml' ? 'selected' : '' }}>ml</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="imagen" class="block text-sm font-semibold text-gray-700">Imagen (Opcional)</label>
                    <input type="file" name="imagen" id="imagen" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" accept="image/*">
                    @if ($insumo->imagen)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $insumo->imagen) }}" alt="{{ $insumo->nombre }}" class="h-24 w-auto rounded-lg shadow">
                            <p class="text-sm text-gray-600">Imagen actual</p>
                        </div>
                    @endif
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Actualizar
                    </button>
                    <a href="{{ route('insumos.index') }}" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700 transition duration-200">
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
                text: '¿Quieres actualizar los datos de este insumo?',
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