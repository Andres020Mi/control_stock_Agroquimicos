@extends('layouts.master')

@section('title')
    Editar Proveedor
@endsection

@section('links_css_head')
    <style>
        /* Reutilizamos los estilos base de las vistas anteriores */
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

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
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
                <h3 class="card-title">Editar Proveedor</h3>
            </div>
            <div class="card-body">
                @if (isset($proveedor) && $proveedor->id)
                    <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST" class="update-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nombre" class="block font-semibold mb-2">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $proveedor->nombre) }}"
                                   class="form-control @error('nombre') is-invalid @enderror" required
                                   placeholder="Ingrese el nombre del proveedor">
                            @error('nombre')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nit" class="block font-semibold mb-2">NIT</label>
                            <input type="text" name="nit" id="nit" value="{{ old('nit', $proveedor->nit) }}"
                                   class="form-control @error('nit') is-invalid @enderror"
                                   placeholder="Ingrese el NIT del proveedor">
                            @error('nit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telefono" class="block font-semibold mb-2">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $proveedor->telefono) }}"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   placeholder="Ingrese el teléfono">
                            @error('telefono')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="block font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $proveedor->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Ingrese el email">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="direccion" class="block font-semibold mb-2">Dirección</label>
                            <textarea name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" rows="3"
                                      placeholder="Ingrese la dirección">{{ old('direccion', $proveedor->direccion) }}</textarea>
                            @error('direccion')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-success" id="submit-btn">
                                <i class="fas fa-save"></i> <span class="btn-text">Actualizar Proveedor</span>
                                <span class="spinner" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                @else
                    <div class="alert alert-danger">
                        No se encontró el proveedor para editar.
                    </div>
                @endif
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
                const $submitBtn = $('#submit-btn');
                const $btnText = $submitBtn.find('.btn-text');
                const $spinner = $submitBtn.find('.spinner');

                // Limpiar errores anteriores
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres actualizar los datos de este proveedor?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#15803d',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Deshabilitar botón y mostrar spinner
                        $submitBtn.prop('disabled', true);
                        $btnText.hide();
                        $spinner.show();

                        $.ajax({
                            url: form.action,
                            method: 'POST',
                            data: $(form).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: '¡Éxito!',
                                    text: 'Proveedor actualizado correctamente.',
                                    icon: 'success',
                                    confirmButtonColor: '#15803d'
                                }).then(() => {
                                    window.location.href = "{{ route('proveedores.index') }}";
                                });
                            },
                            error: function(xhr) {
                                let errorMsg = 'Ocurrió un error al actualizar el proveedor.';
                                if (xhr.status === 422) { // Errores de validación
                                    const errors = xhr.responseJSON.errors;
                                    // Mostrar errores en los campos
                                    $.each(errors, function(field, messages) {
                                        const $input = $(`[name="${field}"]`);
                                        $input.addClass('is-invalid');
                                        $input.next('.invalid-feedback').text(messages[0]);
                                    });
                                    // Mostrar mensaje general en SweetAlert
                                    errorMsg = Object.values(errors).flat().join('<br>');
                                }
                                Swal.fire({
                                    title: 'Error',
                                    html: errorMsg,
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545'
                                });
                            },
                            complete: function() {
                                // Restaurar botón
                                $submitBtn.prop('disabled', false);
                                $btnText.show();
                                $spinner.hide();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection