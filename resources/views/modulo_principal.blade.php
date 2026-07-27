<x-app-layout>
    <div class="py-8 px-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-2xl font-bold mb-4 text-gray-800">PANEL DE CONTROL OFICIAL</h3>
            <p class="mb-6 text-gray-600">Bienvenido al sistema colaborativo de información sobre zonas con riesgo delictivo en Cochabamba. Desde aquí puedes acceder a las herramientas de análisis, validación y gestión de incidentes reportados por ciudadanos.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                <!-- Mapa interactivo -->
                <div class="bg-green-100 p-4 rounded-lg shadow">
                    <h4 class="text-xl font-semibold text-green-800 mb-2">MAPA DE ZONAS DELICTIVAS</h4>
                    <p class="text-gray-700 mb-1">Delitos actualmente visualizados en el mapa:</p>
                    <span class="text-3xl font-bold text-green-900">{{ $totalDelitos }}</span>
                    <p class="text-sm text-gray-600 mt-2">Incluye hotspots y clasificación por tipo.</p>
                </div>

                <!-- Reportes Ciudadanos -->
                <div class="bg-blue-100 p-4 rounded-lg shadow">
                    <h4 class="text-xl font-semibold text-blue-800 mb-2">REPORTES CIUDADANOS</h4>
                    <p class="text-gray-700 mb-1">Reportes ciudadanos recibidos:</p>
                    <span class="text-3xl font-bold text-blue-900">{{ $totalReportes }}</span>
                    <p class="text-sm text-gray-600 mt-2">Incluye ubicación, tipo de delito y detalles adjuntos.</p>
                </div>

                <!-- Gestor de Delitos -->
                <div class="bg-yellow-100 p-4 rounded-lg shadow">
                    <h4 class="text-xl font-semibold text-yellow-800 mb-2">GESTOR DE DELITOS</h4>
                    <p class="text-gray-700 mb-1">Delitos confirmados en el sistema:</p>
                    <span class="text-3xl font-bold text-yellow-900">{{ $totalDelitos }}</span>

                    @isset($delitosPendientes)
                        <p class="mt-2 text-sm text-red-600 font-semibold">Pendientes por validar: {{ $delitosPendientes }}</p>
                    @endisset

                    <p class="text-sm text-gray-600 mt-2">Puedes gestionar, editar o eliminar delitos registrados.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
