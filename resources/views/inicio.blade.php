<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Información Ciudadana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .btn-verde {
            background-color: #4B5320;
            color: white;
        }

        .btn-verde:hover {
            background-color: #3a4420;
        }

        .text-verde {
            color: #4B5320;
        }

        .bg-verde-suave {
            background-color: #f3f5ec;
        }

        .bg-verde-oscuro {
            background-color: #3a4420;
        }

        .bg-verde-claro {
            background-color: #dbe4c5;
        }

        .header {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
                    <nav class="nav">
                <img src="{{ asset('imagenes/logo1.png') }}" alt="Logo IT Security" class="logo">
                <a href="/">INICIO</a>
                <a href="/denuncia">REALIZAR DENUNCIA</a>

                <div class="auth-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            MODULO OFICIAL
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            CONECTARSE
                        </a>
                        {{-- REGISTRARSE removido del inicio --}}
                    @endauth
                </div>
            </nav>

    </div>

    <!-- HERO -->
    <section class="bg-verde-claro py-14 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-verde mb-4">
                Sistema Web de Información sobre Zonas con Riesgo Delictivo en Cochabamba
            </h2>
            <p class="text-gray-700 text-lg mb-6">
                Este sistema permite a los ciudadanos reportar delitos de forma sencilla y ayuda a las autoridades policiales a identificar zonas críticas mediante mapas interactivos, estadísticas y análisis de datos delictivos en tiempo real.
            </p>
            <a href="/denuncia" class="inline-block bg-[#4B5320] text-white px-6 py-3 rounded-full text-sm hover:bg-[#3a4420]">
                Realizar Denuncia
            </a>
        </div>
    </section>

    <!-- FUNCIONALIDADES -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-2xl font-semibold mb-10 text-verde">¿Qué ofrece este sistema?</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h4 class="font-bold text-lg mb-2 text-verde">📌 Denuncia Ciudadana</h4>
                    <p class="text-gray-600 text-sm">
                        Los ciudadanos pueden reportar delitos sin necesidad de registrarse. El formulario incluye campos de datos personales y un mapa simple para marcar la ubicación exacta del hecho delictivo.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-2 text-verde">🛡️ Módulo para Oficiales</h4>
                    <p class="text-gray-600 text-sm">
                        Acceso exclusivo para oficiales autorizados, quienes pueden gestionar denuncias, analizar zonas peligrosas y consultar estadísticas. Incluye filtros por tipo de delito, fecha y sistema de notificaciones.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-2 text-verde">🗺️ Mapa Interactivo con Hotspots</h4>
                    <p class="text-gray-600 text-sm">
                        Los oficiales pueden visualizar un mapa en alta definición que destaca zonas con alta concentración delictiva mediante contornos (hotspots) y marcadores.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-2 text-verde">📊 Análisis y Estadísticas</h4>
                    <p class="text-gray-600 text-sm">
                        El sistema genera porcentajes por tipo de delito y muestra información visual para la toma de decisiones estratégicas en patrullaje y prevención.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-2 text-verde">🔔 Alertas y Actualizaciones</h4>
                    <p class="text-gray-600 text-sm">
                        Se notifica a los oficiales sobre nuevas denuncias y se mantiene actualizado el mapa con los últimos reportes ciudadanos.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-2 text-verde">🔒 Confidencialidad Garantizada</h4>
                    <p class="text-gray-600 text-sm">
                        Toda la información personal enviada por el ciudadano es tratada con absoluta reserva, conforme al Artículo 21 de la Constitución Política del Estado.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- NOTICIAS -->
    <section class="bg-verde-suave py-14">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-2xl font-semibold text-center mb-10 text-verde">Últimas Noticias y Alertas</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-semibold text-lg mb-2 text-verde">Robo en zona norte</h4>
                    <p class="text-sm text-gray-600">Se reportaron varios robos en la zona norte durante la semana pasada. Se recomienda precaución.</p>
                    <a href="#" class="text-verde text-sm mt-3 inline-block hover:underline">Ver más</a>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-semibold text-lg mb-2 text-verde">Nueva patrulla activa</h4>
                    <p class="text-sm text-gray-600">Se ha desplegado un nuevo grupo de patrullaje en la zona sur para mayor vigilancia.</p>
                    <a href="#" class="text-verde text-sm mt-3 inline-block hover:underline">Ver más</a>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-semibold text-lg mb-2 text-verde">Consejos de seguridad</h4>
                    <p class="text-sm text-gray-600">Descubre cómo protegerte mejor en tu barrio con estos consejos de seguridad urbana.</p>
                    <a href="#" class="text-verde text-sm mt-3 inline-block hover:underline">Leer más</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contacto" class="bg-verde-oscuro text-white py-10">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h4 class="text-xl font-semibold mb-2">Contacto</h4>
            <p class="text-sm">¿Tienes dudas o sugerencias? Escríbenos a: <strong>snifferowo@gmail.com</strong></p>
            <p class="text-sm mt-2">© {{ date('Y') }} Sistema de Información de Seguridad Ciudadana - Todos los derechos reservados</p>
        </div>
    </footer>

</body>
</html>

