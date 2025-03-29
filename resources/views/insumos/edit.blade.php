@extends('layouts.master')

@section('title')
    Editar Insumo
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

        img.current-image {
            max-height: 6rem;
            width: auto;
            border-radius: 0.25rem;
            margin-top: 0.5rem;
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
                <h3 class="card-title">Editar Insumo</h3>
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

                <form id="update-form" action="{{ route('insumos.update', $insumo->id) }}" method="POST" enctype="multipart/form-data" class="update-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre" class="block font-semibold mb-2">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $insumo->nombre) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="composicion_quimica" class="block font-semibold mb-2">Composición Química</label>
                        <input type="text" name="composicion_quimica" id="composicion_quimica" class="form-control" value="{{ old('composicion_quimica', $insumo->composicion_quimica) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="unidad_de_medida" class="block font-semibold mb-2">Unidad de Medida</label>
                        <select name="unidad_de_medida" id="unidad_de_medida" class="form-control" required>
                            <option value="kg" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                            <option value="g" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                            <option value="l" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'l' ? 'selected' : '' }}>Litros (l)</option>
                            <option value="ml" {{ old('unidad_de_medida', $insumo->unidad_de_medida) == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="imagen" class="block font-semibold mb-2">Imagen (Opcional)</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                        @if ($insumo->imagen)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $insumo->imagen) }}" alt="{{ $insumo->nombre }}" class="current-image">
                                <p class="text-sm text-gray-600 mt-1">Imagen actual</p>
                            </div>
                        @endif
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Actualizar
                        </button>
                        <a href="{{ route('insumos.index') }}" class="btn btn-secondary">
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
    <script src="{{ asset('DataTables/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.update-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres actualizar los datos de este insumo?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#15803d',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection