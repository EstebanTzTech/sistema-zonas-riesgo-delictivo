<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Modificaciones de Delitos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Registro de actividades</h3>

                    @if($historial->isEmpty())
                        <p class="text-gray-600">No hay registros de modificaciones todavía.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">#</th>
                                        <th class="border px-4 py-2 text-left">Delito</th>
                                        <th class="border px-4 py-2 text-left">Acción</th>
                                        <th class="border px-4 py-2 text-left">Usuario</th>
                                        <th class="border px-4 py-2 text-left">Descripción</th>
                                        <th class="border px-4 py-2 text-left">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historial as $registro)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border px-4 py-2">{{ $registro->id }}</td>
                                            
                                            <td class="border px-4 py-2">
                                                {{-- 
                                                  PRIORIDAD: 
                                                  1. Campo directo guardado en el log (tipo_delito_nombre).
                                                  2. Relación Eloquent (delito->tipo_delito).
                                                  3. Mensaje de defecto.
                                                --}}
                                                @if ($registro->tipo_delito_nombre)
                                                    {{ $registro->tipo_delito_nombre }}
                                                @else
                                                    {{ $registro->delito->tipo_delito ?? '— Eliminado/Desconocido —' }}
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="px-2 py-1 rounded text-sm
                                                     @if($registro->accion == 'editar') bg-yellow-100 text-yellow-800 
                                                     @elseif($registro->accion == 'eliminar') bg-red-100 text-red-800 
                                                     @else bg-blue-100 text-blue-800 @endif">
                                                     {{ ucfirst($registro->accion) }}
                                                </span>
                                            </td>
                                            
                                            <td class="border px-4 py-2">
                                                {{ $registro->usuario->name ?? 'Desconocido' }}
                                            </td>

                                            <td class="border px-4 py-2">
                                                {{ $registro->descripcion_cambio ?? '-' }}
                                            </td>

                                            <td class="border px-4 py-2">
                                                {{ \Carbon\Carbon::parse($registro->fecha_accion)->format('d/m/Y H:i:s') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
