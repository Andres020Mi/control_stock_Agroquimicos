@extends('layouts.master')

@section('title')
    Solicitar Edición de Movimiento
@endsection

@section('links_css_head')
    <style>
        /* Estilos ajustados para compatibilidad con AdminLTE y responsividad */
        .content-wrapper {
            padding: 20px;
        }

        .card {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
        }

        .card-header {
            background-color: #15803d;
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
        }

        .card-body {
            padding: 1.25rem;
        }

        .alert-danger {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
            border-radius: 0.25rem;
        }

        .btn-success {
            background-color: #15803d;
            border-color: #15803d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            min-width: 150px; /* Tamaño uniforme */
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-success:hover {
            background-color: #166534;
            border-color: #166534;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.15s ease-in-out;
            min-width: 150px; /* Tamaño uniforme */
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        select:focus, input[type="number"]:focus {
            border-color: #15803d;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25);
        }

        .error-border {
            border-color: #dc3545 !important;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .info-text {
            color: #6c757d;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Estilos para la tabla de datos actuales */
        .data-table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .data-table th, .data-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }

        .data-table th {
            background-color: #e9ecef;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
        }

        .data-table td {
            font-size: 0.875rem;
            color: #212529;
        }

        /* Estilos para el formulario */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group i {
            position: absolute;
            left: 10px;
            top: 38px; /* Ajustado para alinearse con el input */
            color: #6c757d;
        }

        .form-group select, .form-group input[type="number"] {
            padding-left: 2rem; /* Espacio para el ícono */
        }

        @media (max-width: 768px) {
            .data-table th, .data-table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            .data-table th {
                background-color: #e9ecef;
            }

            .data-table td {
                border-top: none;
            }

            .btn-success, .btn-secondary {
                min-width: 120px; /* Tamaño ajustado para móviles */
                padding: 0.3rem 0.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Solicitar Edición de Movimiento: #{{ $movimiento->id }}</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Mostrar información actual del movimiento en una tabla -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Datos Actuales del Movimiento</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tipo de Movimiento</th>
                                <th>Stock Asociado</th>
                                <th>Cantidad</th>
                                <th>Unidad de Producción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ ucfirst($movimiento->tipo) }}</td>
                                <td>
                                    {{ $movimiento->stock ? $movimiento->stock->id . ' (' . $movimiento->stock->insumo->nombre . ' - ' . $movimiento->stock->almacen->nombre . ')' : 'Stock no encontrado' }}
                                </td>
                                <td>{{ $movimiento->cantidad }} {{ $movimiento->stock && $movimiento->stock->insumo ? $movimiento->stock->insumo->unidad_de_medida : '' }}</td>
                                <td>{{ $movimiento->unidadDeProduccion ? $movimiento->unidadDeProduccion->nombre : 'No asignada' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario para solicitar edición -->
                <form action="{{ route('movimientos.solicitarEdicion', $movimiento->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="tipo">Tipo de Movimiento</label>
                        <i class="fas fa-exchange-alt"></i>
                        <select name="tipo" id="tipo" class="@error('tipo') error-border @enderror">
                            <option value="">Seleccione un tipo</option>
                            <option value="entrada" {{ old('tipo', $movimiento->tipo) == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="salida" {{ old('tipo', $movimiento->tipo) == 'salida' ? 'selected' : '' }}>Salida</option>
                        </select>
                        @error('tipo')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_stock">Stock Asociado</label>
                        <i class="fas fa-box"></i>
                        <select name="id_stock" id="id_stock" class="@error('id_stock') error-border @enderror">
                            <option value="">Seleccione un stock</option>
                            @foreach ($stocks as $stock)
                                <option value="{{ $stock->id }}" data-cantidad="{{ $stock->cantidad }}" {{ old('id_stock', $movimiento->id_stock) == $stock->id ? 'selected' : '' }}>
                                    {{ $stock->id }} ({{ $stock->insumo->nombre }} - {{ $stock->almacen->nombre }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_stock')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                        <p id="cantidad-disponible" class="info-text"></p>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <i class="fas fa-hashtag"></i>
                        <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', $movimiento->cantidad) }}" min="1" class="@error('cantidad') error-border @enderror">
                        @error('cantidad')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_unidad_de_produccion">Unidad de Producción (opcional)</label>
                        <i class="fas fa-building"></i>
                        <select name="id_unidad_de_produccion" id="id_unidad_de_produccion" class="@error('id_unidad_de_produccion') error-border @enderror">
                            <option value="">Seleccione una unidad (opcional)</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}" {{ old('id_unidad_de_produccion', $movimiento->id_unidad_de_produccion) == $unidad->id ? 'selected' : '' }}>
                                    {{ $unidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_unidad_de_produccion')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Solicitar Edición
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script>
        document.getElementById('id_stock').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const cantidadDisponible = selectedOption.getAttribute('data-cantidad');
            const cantidadDisponibleElement = document.getElementById('cantidad-disponible');

            if (cantidadDisponible !== null) {
                cantidadDisponibleElement.textContent = `Cantidad disponible: ${cantidadDisponible}`;
            } else {
                cantidadDisponibleElement.textContent = '';
            }
        });

        // Disparar el evento change al cargar la página para mostrar la cantidad inicial
        document.getElementById('id_stock').dispatchEvent(new Event('change'));
    </script>
@endsection