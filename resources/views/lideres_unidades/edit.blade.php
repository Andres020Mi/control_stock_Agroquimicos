@extends('layouts.app')

@section('header')
    Editar Asignaciones de Líder
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Editar Asignaciones de Líder: {{ $user->name }}</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-lg shadow-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lideres_unidades.update', $user->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="unidades" class="block text-sm font-medium text-gray-700">Unidades de Producción</label>
                <select name="unidades[]" id="unidades" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('unidades') border-red-500 @enderror">
                    @foreach ($unidades as $unidad)
                        <option value="{{ $unidad->id }}" {{ in_array($unidad->id, $asignadas) ? 'selected' : '' }}>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
                @error('unidades')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
@endsection