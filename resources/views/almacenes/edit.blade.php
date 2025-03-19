@extends('layouts.app')

@section('header')
    Editar Almacén
@endsection

@section('content')
    <div class="container mt-5">
        <h1>Editar Almacén</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('almacenes.update', $almacen->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $almacen->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $almacen->descripcion) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection