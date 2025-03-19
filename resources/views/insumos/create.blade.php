<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Insumo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Assuming Tailwind/Bootstrap via app.css -->
</head>
<body>
    <div class="container mt-5">
        <h1>Crear Nuevo Insumo</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('insumos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
                <label for="composicion_quimica" class="form-label">Composición Química</label>
                <input type="text" name="composicion_quimica" id="composicion_quimica" class="form-control" value="{{ old('composicion_quimica') }}" required>
            </div>

            <div class="mb-3">
                <label for="unidad_de_medida" class="form-label">Unidad de Medida</label>
                <select name="unidad_de_medida" id="unidad_de_medida" class="form-control" required>
                    <option value="kg" {{ old('unidad_de_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                    <option value="g" {{ old('unidad_de_medida') == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                    <option value="l" {{ old('unidad_de_medida') == 'l' ? 'selected' : '' }}>Litros (l)</option>
                    <option value="ml" {{ old('unidad_de_medida') == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen (Opcional)</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('insumos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>