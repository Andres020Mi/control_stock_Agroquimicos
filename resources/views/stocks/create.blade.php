<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Stock</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Crear Nuevo Stock</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stocks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_insumo" class="form-label">Insumo</label>
                <select name="id_insumo" id="id_insumo" class="form-control" required>
                    <option value="">Seleccione un insumo</option>
                    @foreach ($insumos as $insumo)
                        <option value="{{ $insumo->id }}" {{ old('id_insumo') == $insumo->id ? 'selected' : '' }}>
                            {{ $insumo->nombre }} ({{ $insumo->unidad_de_medida }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad') }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="fecha_de_vencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="form-control" value="{{ old('fecha_de_vencimiento') }}" required>
            </div>

            <div class="mb-3">
                <label for="id_almacen" class="form-label">Almacén</label>
                <select name="id_almacen" id="id_almacen" class="form-control" required>
                    <option value="">Seleccione un almacén</option>
                    @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ old('id_almacen') == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>