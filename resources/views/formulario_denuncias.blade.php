<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Denuncias</title>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #556B2F;
            color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            color: #333;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #2f4f2f;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        .btn-enviar {
            width: 100%;
            background-color: #556B2F;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-enviar:hover {
            background-color: #445522;
        }

        small {
            display: block;
            margin-top: 10px;
            font-style: italic;
            color: #777;
            text-align: center;
        }

        #map {
            height: 350px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .search-group {
            display: flex;
            margin-bottom: 10px;
        }

        .search-group input {
            flex: 1;
            margin-right: 10px;
        }

        .search-group button {
            background-color: #556B2F;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        .search-group button:hover {
            background-color: #445522;
        }
                input[type="checkbox"] {
            transform: scale(1.1);
            cursor: pointer;
        }
    /* NUEVOS ESTILOS PARA LOS TÉRMINOS */
            .termino-item {
                display: flex !important;
                align-items: flex-start !important;
                margin-bottom: 15px;
                gap: 8px;
            }

            .termino-item input[type="checkbox"] {
                width: auto !important;
                margin: 0 !important;
                margin-top: 2px !important;
                flex-shrink: 0;
                padding: 0 !important;
            }

            .termino-item label {
                display: inline !important;
                flex: 1;
                font-weight: 400 !important;
                line-height: 1.6;
                cursor: pointer;
                margin: 0 !important;
                margin-bottom: 0 !important;
            }
            body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #5a7129;
            color: white;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* --- Encabezado --- */
        .header {
            padding: 1px;
            background: white;
            color: #4B5320;
            text-align: center;
            font-size: 1.8em;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* --- Navegación --- */
        .nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background: white;
            padding: 12px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav a {
            color: #4B5320;
            text-decoration: none;
            padding: 8px 16px;
            font-size: 0.9em;
            font-weight: bold;
            border: 2px solid transparent;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
            margin-left: 15px;
        }

        .nav a:hover {
            background: #4B5320;
            color: white;
            border-color: #4B5320;
            box-shadow: 0 3px 8px rgba(75, 83, 32, 0.3);
        }

        .nav img.logo {
            height: 150px;
            margin-right: auto;
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
    <div class="container">
        @if(session('success'))
    <p style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; font-weight: bold;">
        {{ session('success') }}
    </p>
@endif

        <h2>Formulario de Denuncia Ciudadana</h2>

        <form action="{{ route('denuncia.guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="apellido_paterno">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" required>

            <label for="apellido_materno">Apellido Materno</label>
            <input type="text" name="apellido_materno" id="apellido_materno" required>

            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" min="10" max="120" required>

            <label for="direccion">Dirección de Domicilio</label>
            <input type="text" name="direccion" id="direccion" required>

            <label for="correo">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" required>

            <label for="celular">Número de Celular</label>
            <input type="text" name="celular" id="celular" required>

            <label for="ci">Número de Carnet de Identidad (CI)</label>
            <input type="text" name="ci" id="ci" required>

            <label for="foto_carnet_anverso">Foto del Carnet (Anverso)</label>
            <input type="file" name="foto_carnet_anverso" id="foto_carnet_anverso" accept="image/*" required>

            <label for="foto_carnet_reverso">Foto del Carnet (Reverso)</label>
            <input type="file" name="foto_carnet_reverso" id="foto_carnet_reverso" accept="image/*" required>

            <label for="foto_rostro">Foto de rostro del denunciante</label>
            <input type="file" name="foto_rostro" id="foto_rostro" accept="image/*" required>

            <label for="fecha_delito">Fecha en que ocurrió el delito</label>
            <input type="date" name="fecha_delito" id="fecha_delito" required>

            <label for="descripcion">Título de la Denuncia</label>
            <input type="text" name="descripcion" id="descripcion" required>

            <label for="categoria_delito">Delito Cometido</label>
            <select name="categoria_delito" id="categoria_delito" required>
                <option value="">Seleccione una categoría</option>
                <option>Robo con arma</option>
                <option>Robo de vehículo</option>
                <option>Tráfico de drogas</option>
                <option>Agresión sexual</option>
                <option>Secuestro</option>
                <option>Robo a propiedad</option>
                <option>Homicidio</option>
                <option>Peleas callejeras</option>
                <option>Otros</option>
            </select>

            <label for="detalle">Detalle de lo ocurrido</label>
            <textarea name="detalle" id="detalle" rows="4" required></textarea>

            <label for="buscar_ubicacion">Buscar ubicación en el mapa</label>
            <div class="search-group">
                <input type="text" id="buscar_ubicacion" placeholder="Ej: Av. Blanco Galindo, Cochabamba">
                <button type="button" onclick="buscarUbicacion()">Buscar</button>
            </div>

            <label>Ubicación del Delito</label>
            <div id="map"></div>

            <input type="hidden" name="latitud" id="latitud">
            <input type="hidden" name="longitud" id="longitud">

            <small>Haz clic en el mapa para seleccionar la ubicación del delito.</small>

           <div style="margin-bottom: 30px; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; color: #333; font-size: 13px;">
    <p style="font-weight: 600; margin-bottom: 15px; font-size: 14px; color: #2f4f2f;">
        Antes de continuar, le invitamos a leer atentamente el siguiente aviso de privacidad: *
    </p>

    <!-- Primer término -->
    <div class="termino-item">
        <input type="checkbox" id="termino1" name="acepto_articulo_166" required>
        <label for="termino1">
            Declaro conocer el <strong>ARTÍCULO 166° (Código Penal)</strong> – <em>(ACUSACIÓN Y DENUNCIA FALSA)</em>. Acepto que si denuncio falsamente a una persona, puedo recibir sanciones legales. Además, consiento que todos mis datos sean tratados con absoluta reserva y confidencialidad por la Inspectoría General y el Departamento Nacional de Transparencia de la Policía Boliviana.
        </label>
    </div>

    <!-- Segundo término -->
    <div class="termino-item">
        <input type="checkbox" id="termino2" name="acepto_reserva_datos" required>
        <label for="termino2">
            Estoy de acuerdo en que todos mis datos serán tratados con absoluta reserva y confidencialidad por la Inspectoría General y el Departamento Nacional de Transparencia de la Policía Boliviana.
        </label>
    </div>
</div>

<button type="submit" class="btn-enviar">Enviar Denuncia</button>

            <small>
                Estimado/a ciudadano/a,<br>
                Le informamos que toda la información personal proporcionada en el proceso de denuncia será tratada con absoluta confidencialidad, conforme a lo establecido en el <strong>Artículo 21 de la Constitución Política del Estado Plurinacional de Bolivia</strong>, que garantiza el derecho a la privacidad, la intimidad personal y la protección de datos personales.<br>
                Atentamente,<br>
                Sistema de Denuncias de Cochabamba
            </small>
            
        </form>
    </div>

    <script>
        const centroInicial = [-17.3895, -66.1568]; // Cochabamba
        const map = L.map('map').setView(centroInicial, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marcador;

        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);

            if (marcador) {
                marcador.setLatLng(e.latlng);
            } else {
                marcador = L.marker(e.latlng).addTo(map);
            }

            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lng;
        });

        function buscarUbicacion() {
            const lugar = document.getElementById('buscar_ubicacion').value;
            if (!lugar) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(lugar)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        map.setView([lat, lon], 16);

                        if (marcador) {
                            marcador.setLatLng([lat, lon]);
                        } else {
                            marcador = L.marker([lat, lon]).addTo(map);
                        }

                        document.getElementById('latitud').value = lat.toFixed(6);
                        document.getElementById('longitud').value = lon.toFixed(6);
                    } else {
                        alert('No se encontró la ubicación.');
                    }
                })
                .catch(err => {
                    alert('Error al buscar la ubicación.');
                    console.error(err);
                });
        }
    </script>
</body>
</html> 

