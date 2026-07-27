<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestor de Usuarios Registrados') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Usuarios del Sistema</h3>

                    @if($users->isEmpty())
                        <p class="text-gray-600">No hay usuarios registrados en el sistema.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">ID</th>
                                        <th class="border px-4 py-2 text-left">Nombre</th>
                                        <th class="border px-4 py-2 text-left">Email</th>
                                        <th class="border px-4 py-2 text-left">Verificado</th>
                                        <th class="border px-4 py-2 text-left">Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border px-4 py-2">{{ $user->id }}</td>
                                            <td class="border px-4 py-2 font-medium">{{ $user->name }}</td>
                                            <td class="border px-4 py-2">{{ $user->email }}</td>
                                            
                                            <td class="border px-4 py-2">
                                                @if($user->email_verified_at)
                                                    <span class="text-green-600">Sí ({{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y') }})</span>
                                                @else
                                                    <span class="text-red-500">No</span>
                                                @endif
                                            </td>

                                            <td class="border px-4 py-2">
                                                {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}
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