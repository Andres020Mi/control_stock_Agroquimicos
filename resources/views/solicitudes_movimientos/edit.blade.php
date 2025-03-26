@extends('layouts.app')

@section('header')
    Revisar Solicitud de Movimiento
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Revisar Solicitud de Movimiento</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-lg shadow-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Detalles de la Solicitud</h2>
            <p><strong>Solicitante:</strong> {{ $solicitud->user->name }}</p>
            <p><strong>Tipo de Solicitud:</strong> {{ $solicitud->tipo }}</p>
            <p><strong>Movimiento ID:</strong> {{ $solicitud->movimiento->id }}</p>
            <p><strong>Estado Actual:</strong> {{ $solicitud->estado }}</p>
        </div>

        @if ($solicitud->tipo === 'editar' && !empty($solicitud->datos_nuevos))
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Datos Propuestos</h2>
                <p><strong>Tipo:</strong> {{ $solicitud->datos_nuevos['tipo'] ?? 'No especificado' }}</p>
                <p><strong>Stock:</strong> 
                    @php
                        $stockEncontrado = $stocks->firstWhere('id', $solicitud->datos_nuevos['id_stock'] ?? null);
                    @endphp
                    {{ $stockEncontrado ? $stockEncontrado->insumo->nombre . ' (Almacén: ' . $stockEncontrado->almacen->nombre . ')' : 'No especificado' }}
                </p>
                <p><strong>Cantidad:</strong> {{ $solicitud->datos_nuevos['cantidad'] ?? 'No especificado' }}</p>
                <p><strong>Unidad de Producción:</strong> 
                    @php
                        $unidadEncontrada = $unidades->firstWhere('id', $solicitud->datos_nuevos['id_unidad_de_produccion'] ?? null);
                    @endphp
                    {{ $unidadEncontrada ? $unidadEncontrada->nombre : 'Ninguna' }}
                </p>
            </div>
        @endif

        <form action="{{ route('solicitudes_movimientos.update', $solicitud->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('estado') border-red-500 @enderror">
                    <option value="aprobada">Aprobar</option>
                    <option value="rechazada">Rechazar</option>
                </select>
                @error('estado')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="motivo_rechazo" class="block text-sm font-medium text-gray-700">Motivo de Rechazo (si aplica)</label>
                <textarea name="motivo_rechazo" id="motivo_rechazo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('motivo_rechazo') border-red-500 @enderror">{{ old('motivo_rechazo') }}</textarea>
                @error('motivo_rechazo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition duration-200">
                    Procesar Solicitud
                </button>
            </div>
        </form>
    </div>
@endsection