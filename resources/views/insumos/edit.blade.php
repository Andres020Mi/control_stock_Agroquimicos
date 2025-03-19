@extends('layouts.app')

@section('header')
    Editar Insumo
@endsection

@section('content')
    <div class="container mt-5">
        <h1>Editar Insumo</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('insumos.update', $insumo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $insumo->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="composicion_quimica" class="form-label">Composición Química</label>
                <input type="text" name="composicion_quimica" id="composicion_quimica" class="form-control" value="{{ old('composicion_quimica', $insumo->composicion_quimica) }}" required>
            </div>

            <div class="mb-3">
                <label for="unidad_de_medida" class="form-label">Unidad de Medida</label>
                <select name="unidad_de_medida" id="unidad_de_medida" class="form-control" required>
                    <option value="kg" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'kg' ? 'selected' : '' }}>kg</option>
                    <option value="g" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'g' ? 'selected' : '' }}>g</option>
                    <option value="l" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'l' ? 'selected' : '' }}>l</option>
                    <option value="ml" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'ml' ? 'selected' : '' }}>ml</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen (Opcional)</label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                @if ($insumo->imagen)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $insumo->imagen) }}" alt="{{ $insumo->nombre }}" style="max-width: 100px;">
                        <p>Imagen actual</p>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('insumos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection