@extends('layouts.app')

@section('header')
    Editar Stock
@endsection

@section('content')
    <div class="container mt-5">
        <h1>Editar Stock</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_insumo" class="form-label">Insumo (No editable)</label>
                <input type="text" class="form-control" value="{{ $stock->insumo->nombre }}" disabled>
                <input type="hidden" name="id_insumo" value="{{ $stock->id_insumo }}">
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad', $stock->cantidad) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label for="fecha_de_vencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="form-control" value="{{ old('fecha_de_vencimiento', $stock->fecha_de_vencimiento) }}" required>
            </div>

            <div class="mb-3">
                <label for="id_almacen" class="form-label">Almacén</label>
                <select name="id_almacen" id="id_almacen" class="form-control" required>
                    @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ old('id_almacen', $stock->id_almacen) == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="utilizable" {{ old('estado', $stock->estado) == 'utilizable' ? 'selected' : '' }}>Utilizable</option>
                    <option value="caducado" {{ old('estado', $stock->estado) == 'caducado' ? 'selected' : '' }}>Caducado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection