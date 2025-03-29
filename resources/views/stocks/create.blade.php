@extends('layouts.master')

@section('title')
    Crear Stock de Agroquímicos
@endsection

@section('links_css_head')
    <style>
        /* Reutilizamos los estilos base de la vista inicial */
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #15803d;
            box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25);
            outline: none;
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
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1rem;
            }
            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                width: 100%;
            }
            .btn {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Nuevo Stock</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stocks.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="id_insumo" class="block font-semibold mb-2">Insumo</label>
                        <select name="id_insumo" id="id_insumo" class="form-control" required>
                            <option value="">Seleccione un insumo</option>
                            @foreach ($insumos as $insumo)
                                <option value="{{ $insumo->id }}" {{ old('id_insumo') == $insumo->id ? 'selected' : '' }}>
                                    {{ $insumo->nombre }} ({{ $insumo->unidad_de_medida }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cantidad" class="block font-semibold mb-2">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad') }}" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_de_vencimiento" class="block font-semibold mb-2">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_de_vencimiento" id="fecha_de_vencimiento" class="form-control" value="{{ old('fecha_de_vencimiento') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="id_almacen" class="block font-semibold mb-2">Almacén</label>
                        <select name="id_almacen" id="id_almacen" class="form-control" required>
                            <option value="">Seleccione un almacén</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ old('id_almacen') == $almacen->id ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_proveedor" class="block font-semibold mb-2">Proveedor (Opcional)</label>
                        <select name="id_proveedor" id="id_proveedor" class="form-control">
                            <option value="">Sin proveedor</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ old('id_proveedor') == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Guardar
                        </button>
                        <a href="{{ route('stocks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <script src="{{ asset('DataTables/jquery-3.7.1.min.js') }}"></script>
@endsection