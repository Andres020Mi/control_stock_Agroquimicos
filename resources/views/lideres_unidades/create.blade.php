@extends('layouts.master')

@section('title')
    Asignar Líder a Unidad
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
            border-color: #5a6268;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        select {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #495057;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        select:focus {
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

        .form-group i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
            }

            .form-group label {
                margin-bottom: 0.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Asignar Líder a Unidad</h3>
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

                <form action="{{ route('lideres_unidades.store') }}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="user_id">
                            <i class="fas fa-user"></i> Líder
                        </label>
                        <select name="user_id" id="user_id" class="@error('user_id') error-border @enderror">
                            <option value="">Seleccione un líder</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="unidad_de_produccion_id">
                            <i class="fas fa-building"></i> Unidad de Producción
                        </label>
                        <select name="unidad_de_produccion_id" id="unidad_de_produccion_id" class="@error('unidad_de_produccion_id') error-border @enderror">
                            <option value="">Seleccione una unidad</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}" {{ old('unidad_de_produccion_id') == $unidad->id ? 'selected' : '' }}>
                                    {{ $unidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('unidad_de_produccion_id')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Asignar
                        </button>
                        <a href="{{ route('lideres_unidades.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scritps_end_body')
    <!-- Aquí puedes agregar scripts específicos si los necesitas -->
@endsection