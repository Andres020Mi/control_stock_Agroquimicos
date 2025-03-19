<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Movimiento</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Crear Nuevo Movimiento</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('movimientos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Movimiento</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_stock" class="form-label">Stock</label>
                <select name="id_stock" id="id_stock" class="form-control" required>
                    <option value="">Seleccione un stock</option>
                    @foreach ($stocks as $stock)
                        <option value="{{ $stock->id }}" {{ old('id_stock') == $stock->id ? 'selected' : '' }}>
                            {{ $stock->insumo->nombre }} ({{ $stock->cantidad }} {{ $stock->insumo->unidad_de_medida }}) - Almacén: {{ $stock->almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad') }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="id_unidad_de_produccion" class="form-label">Unidad de Producción (Opcional, solo para salidas)</label>
                <select name="id_unidad_de_produccion" id="id_unidad_de_produccion" class="form-control">
                    <option value="">Ninguna</option>
                    @foreach ($unidades as $unidad)
                        <option value="{{ $unidad->id }}" {{ old('id_unidad_de_produccion') == $unidad->id ? 'selected' : '' }}>
                            {{ $unidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>