@extends('layouts.app')

@section('header')
    Editar Unidad de Producción
@endsection

@section('content')
    <div class="container mt-5">
        <h1>Editar Unidad de Producción</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('unidades_de_produccion.update', $unidad->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $unidad->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $unidad->descripcion) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('unidades_de_produccion.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection