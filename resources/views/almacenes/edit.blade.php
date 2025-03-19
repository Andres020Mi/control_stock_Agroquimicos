@extends('layouts.app')

@section('header')
    Editar Almacén
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Editar Almacén</h1>

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
            <form action="{{ route('almacenes.update', $almacen->id) }}" method="POST" class="update-form">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('nombre', $almacen->nombre) }}" required>
                </div>

                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">Descripción (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" rows="3">{{ old('descripcion', $almacen->descripcion) }}</textarea>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                        Actualizar
                    </button>
                    <a href="{{ route('almacenes.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow hover:bg-gray-600 transition duration-200">
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
                text: '¿Quieres actualizar los datos de este almacén?',
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