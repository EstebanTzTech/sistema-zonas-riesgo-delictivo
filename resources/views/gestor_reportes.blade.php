<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Denuncias</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        /* Estilos generales y tabla igual que antes... */
        .header-container {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #556B2F, transparent);
            z-index: 1;
        }
        h1 {
            background: linear-gradient(135deg, #556B2F 0%, #6B8E23 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            padding: 20px 40px;
            background-color: #fff;
            border-radius: 15px;
            position: relative;
            z-index: 2;
            display: inline-block;
        }
        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-top: 10px;
            font-weight: 300;
        }
        .filters-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .filters-container input,
        .filters-container select {
            padding: 8px;
            margin: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            color: #333;
            background-color: #fdfdfd;
        }
        .filters-container button {
            padding: 8px 12px;
            background-color: #556B2F;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .filters-container button:hover {
            background-color: #445522;
        }
                .filters-container .btn-limpiar {
            background-color:rgb(194, 191, 191); 
            color: #000;               
            margin-left: 10px;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .filters-container .btn-limpiar:hover {
            background-color:rgb(184, 182, 182); 
        }

        .notification {
            background-color: #ffeeba;
            padding: 10px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            color: #856404;
            border: 1px solid #ffeeba;
            text-align: center;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        th, td {
            padding: 16px;
            font-size: 14px;
            color: #333;
        }
        th {
            background-color: #556B2F;
            color: #fff;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 10;
            font-weight: 600;
        }
        tbody tr {
            border-bottom: 5px solid #556B2F;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        tr:nth-child(even) {
            background-color: rgb(209, 211, 204);
        }
        tr:hover {
            background-color: rgb(219, 231, 199);
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        .archivo {
            background-color: rgb(210, 216, 192);
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 6px;
            font-size: 13px;
            color: #445522;
            font-weight: bold;
        }
        .descargar {
            display: inline-block;
            margin-left: 8px;
            padding: 6px 10px;
            background-color: #445522;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }
        .descargar:hover {
            background-color: #333;
        }
        iframe {
            border-radius: 8px;
            border: none;
        }
        nav img {
            max-width: 85px !important;
            height: auto !important;
        }
        .btn-ver-mapa {
            margin-top: 5px;
            padding: 5px 10px;
            background-color: #556B2F;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-ver-mapa:hover {
            background-color: #445522;
        }
        /* Modal estilos */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #f4f4f4;
            margin: 5% auto;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 900px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .modal-close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }
        .modal-close:hover {
            color: #000;
        }
        .modal-iframe {
            width: 100%;
            height: 600px;
            border-radius: 8px;
            border: none;
        }
    </style>
</head>
<body>

@include('layouts.navigation')

<div class="header-container">
    <h1>Gestión de Denuncias Ciudadanas</h1>
    <p class="subtitle">Sistema de monitoreo y seguimiento de denuncias</p>
</div>

@if(session('nuevos_delitos'))
    <div class="notification">
        Se han registrado <strong>{{ session('nuevos_delitos') }}</strong> nuevas denuncias desde tu última visita.
    </div>
@endif

<div class="filters-container">
    <form method="GET" action="{{ route('denuncia.lista') }}">
        <input type="text" name="buscar" placeholder="Buscar por título..." value="{{ request('buscar') }}">
        <select name="categoria">
            <option value="">-- Filtrar por delito --</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                    {{ ucfirst($categoria) }}
                </option>
            @endforeach
        </select>
        <input type="date" name="fecha" value="{{ request('fecha') }}">
        <button type="submit">Filtrar</button>
        <button type="button" class="btn-limpiar" id="btnLimpiar">Limpiar</button>
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>Edad</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>CI</th>
                <th>Archivos</th>
                <th>Fecha Delito</th>
                <th>Título</th>
                <th>Delito</th>
                <th>Detalle</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($denuncias as $d)
                <tr>
                    <td>{{ $d->nombre }} {{ $d->apellido_paterno }} {{ $d->apellido_materno }}</td>
                    <td>{{ $d->edad }}</td>
                    <td>{{ $d->direccion }}</td>
                    <td>{{ $d->correo }}</td>
                    <td>{{ $d->celular }}</td>
                    <td>{{ $d->ci }}</td>
                    <td>
                        <div class="archivo">Carnet Anverso</div>
                        <a href="{{ route('descargar.archivo', basename($d->foto_carnet_anverso)) }}" class="descargar">Descargar</a>

                        <div class="archivo">Carnet Reverso</div>
                        <a href="{{ route('descargar.archivo', basename($d->foto_carnet_reverso)) }}" class="descargar">Descargar</a>

                        <div class="archivo">Foto de Rostro</div>
                        <a href="{{ route('descargar.archivo', basename($d->foto_rostro)) }}" class="descargar">Descargar</a>
                    </td>
                    <td>{{ $d->fecha_delito }}</td>
                    <td>{{ $d->descripcion }}</td>
                    <td>{{ $d->categoria_delito }}</td>
                    <td>{{ $d->detalle }}</td>
                    <td>
                        <iframe
                            width="200"
                            height="150"
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $d->longitud - 0.001 }},{{ $d->latitud - 0.001 }},{{ $d->longitud + 0.001 }},{{ $d->latitud + 0.001 }}&layer=mapnik&marker={{ $d->latitud }},{{ $d->longitud }}"
                            allowfullscreen
                            data-lat="{{ $d->latitud }}"
                            data-lng="{{ $d->longitud }}"
                        ></iframe>
                        <button class="btn-ver-mapa" data-lat="{{ $d->latitud }}" data-lng="{{ $d->longitud }}">
                            Ver mapa completo
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="12">No se encontraron resultados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="modalMapa" class="modal">
    <div class="modal-content">
        <span class="modal-close" id="modalCerrar">&times;</span>
        <iframe id="iframeMapaGrande" class="modal-iframe" src="" allowfullscreen></iframe>
    </div>
</div>

<script>
    // Botón Limpiar filtros
    document.getElementById('btnLimpiar').addEventListener('click', function() {
        const form = this.closest('form');
        form.querySelector('input[name="buscar"]').value = '';
        form.querySelector('select[name="categoria"]').value = '';
        form.querySelector('input[name="fecha"]').value = '';
        form.submit();
    });

    // Modal mapa completo
    const modal = document.getElementById('modalMapa');
    const iframeMapa = document.getElementById('iframeMapaGrande');
    const btnCerrar = document.getElementById('modalCerrar');

    document.querySelectorAll('.btn-ver-mapa').forEach(btn => {
        btn.addEventListener('click', () => {
            const lat = parseFloat(btn.getAttribute('data-lat'));
            const lng = parseFloat(btn.getAttribute('data-lng'));
            const delta = 0.005;
            const bbox = `${lng - delta},${lat - delta},${lng + delta},${lat + delta}`;
            const src = `https://www.openstreetmap.org/export/embed.html?bbox=${bbox}&layer=mapnik&marker=${lat},${lng}`;
            iframeMapa.src = src;
            modal.style.display = 'block';
        });
    });

    btnCerrar.addEventListener('click', () => {
        modal.style.display = 'none';
        iframeMapa.src = '';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            iframeMapa.src = '';
        }
    });
</script>


</body>
</html>





