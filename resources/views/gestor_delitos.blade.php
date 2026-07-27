<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Delitos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eee;
            margin: 0;
        }

        .header-container {
            text-align: center;
            margin-bottom: 40px;
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
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            color: #333;
        }

        th {
            background-color: #556B2F;
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:hover {
            background-color: #fff;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-editar {
            background-color: #4CAF50;
        }

        .btn-editar:hover {
            background-color: #45a049;
        }

        .btn-eliminar {
            background-color: rgb(204, 105, 47);
        }

        .btn-eliminar:hover {
            background-color: #da190b;
        }

        .volver-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: rgb(97, 122, 26);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .volver-btn:hover {
            background-color: rgb(106, 133, 43);
        }

        label {
            color: #333;
        }

        input, select, textarea {
            color: #333;
        }

        .map-mini {
            width: 120px;
            height: 100px;
            cursor: pointer;
            border-radius: 6px;
            overflow: hidden;
        }

        /* ESTILOS DEL MODAL DE EDICIÓN */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            display: none; 
        }

        #modalEditar {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            max-width: 750px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid #ddd;
            display: none; 
        }
        
        #modalEditar h3 {
            font-size: 1.6rem;
            margin-bottom: 20px;
            color: #556B2F;
            font-weight: 600;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            text-align: center;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 25px;
        }

        .full-width {
            grid-column: 1 / -1;
        }
        
        #modalEditar label {
            display: block;
            margin-top: 0; 
            margin-bottom: 5px;
            color: #444;
            font-weight: 500;
            font-size: 0.9rem;
        }

        #modalEditar input:not([type="hidden"]), 
        #modalEditar select, 
        #modalEditar textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 0.95rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        #modalEditar input:focus, 
        #modalEditar select:focus, 
        #modalEditar textarea:focus {
            border-color: #556B2F;
            outline: none;
            box-shadow: 0 0 5px rgba(85, 107, 47, 0.3);
        }
        
        #modalEditar textarea {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .modal-footer button {
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .modal-footer .bg-red-500 {
            background-color: #f44336;
        }
        .modal-footer .bg-red-500:hover {
            background-color: #d32f2f;
        }

        .modal-footer .bg-\[\#556B2F\] {
            background-color: #556B2F;
        }
        .modal-footer .bg-\[\#556B2F\]:hover {
            background-color: #4F6228;
        }

        @media (max-width: 500px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            #modalEditar {
                padding: 15px;
                max-width: 95%;
            }
        }
    </style>
</head>
<body>

@include('layouts.navigation')

<div class="header-container">
    <h1>Gestión de Delitos</h1>
    <p class="subtitle">Sistema de monitoreo y seguimiento de delitos</p>
</div>

@if(session('success'))
    <p style="color: green; text-align:center;">{{ session('success') }}</p>
@endif
<form method="GET" action="{{ route('gestor.delitos') }}" style="margin: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
    <input type="text" name="buscar" placeholder="Buscar" value="{{ request('buscar') }}" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">

    <input type="text" name="zona" placeholder="Zona" value="{{ request('zona') }}" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">

    <select name="tipo" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="">Tipo de delito</option>
        @foreach(['Robo con arma', 'Robo de vehículo', 'Tráfico de drogas', 'Agresión sexual', 'Secuestro', 'Robo a propiedad', 'Homicidio', 'Peleas callejeras', 'Otros'] as $tipo)
            <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
        @endforeach
    </select>

    <select name="riesgo" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="">Riesgo</option>
        @foreach(['Alto', 'Medio', 'Bajo'] as $r)
            <option value="{{ $r }}" {{ request('riesgo') == $r ? 'selected' : '' }}>{{ $r }}</option>
        @endforeach
    </select>

    <select name="fuente" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="">Fuente</option>
        @foreach(['Denuncia Ciudadana', 'Noticia', 'Informe policial'] as $f)
            <option value="{{ $f }}" {{ request('fuente') == $f ? 'selected' : '' }}>{{ $f }}</option>
        @endforeach
    </select>

    <select name="estado" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="">Estado</option>
        @foreach(['Reportado', 'En investigación', 'Cerrado'] as $e)
            <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>{{ $e }}</option>
        @endforeach
    </select>

    <input type="date" name="fecha" value="{{ request('fecha') }}" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">

    <button type="submit" style="background-color: #556B2F; color: white; padding: 8px 12px; border: none; border-radius: 5px;">Filtrar</button>
    <a href="{{ route('gestor.delitos') }}" style="background-color: #ccc; color: black; padding: 8px 12px; border: none; border-radius: 5px; text-decoration: none;">Limpiar</a>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Zona</th>
            <th>Tipo de Delito</th>
            <th>Riesgo</th>
            <th>Fuente</th>
            <th>Estado</th>
            <th>Fecha y Hora</th>
            <th>Descripción</th>
            <th>Ubicación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($delitos as $delito)
            <tr>
                <td>{{ $delito->id }}</td>
                <td>{{ $delito->nombre_zona }}</td>
                <td>{{ $delito->tipo_delito }}</td>
                <td>{{ $delito->nivel_riesgo }}</td>
                <td>{{ $delito->fuente_informacion }}</td>
                <td>{{ $delito->estado_delito }}</td>
                <td>{{ $delito->fecha_hora }}</td>
                <td>{{ $delito->descripcion }}</td>
                <td>
                    <div id="map-{{ $delito->id }}" class="map-mini"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var map{{ $delito->id }} = L.map("map-{{ $delito->id }}", {
                                center: [{{ $delito->latitud_centro }}, {{ $delito->longitud_centro }}],
                                zoom: 15,
                                zoomControl: false,
                                attributionControl: false
                            });

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map{{ $delito->id }});
                            L.marker([{{ $delito->latitud_centro }}, {{ $delito->longitud_centro }}]).addTo(map{{ $delito->id }});

                            map{{ $delito->id }}.on('click', function () {
                                window.location.href = "{{ route('mapa.usuario') }}?lat={{ $delito->latitud_centro }}&lng={{ $delito->longitud_centro }}";
                            });
                        });
                    </script>
                </td>
                <td class="acciones">
    <button onclick="abrirModalEditar({{ $delito }})" class="btn btn-editar">Editar</button>

    <form action="{{ route('gestor.eliminar', $delito->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar este delito?')">Eliminar</button>
    </form>

    <a href="{{ route('delitos.reporte', $delito->id) }}" target="_blank" class="btn" style="background-color:rgb(13, 53, 117); margin-left: 5px;">
        Generar Reporte
    </a>
</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="modalBackdrop" class="modal-backdrop"></div> 

<div id="modalEditar">

    <h3 style="font-size: 18px; margin-bottom: 10px; color: #556B2F;">Editar Delito</h3>

    <form id="formEditar" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit_id">

        <div class="form-grid">
            
            <div>
                <label>Nombre Zona:</label>
                <input type="text" id="edit_nombre_zona" name="nombre_zona" required>
                
                <label>Nivel Riesgo:</label>
                <select id="edit_nivel_riesgo" name="nivel_riesgo">
                    <option>Alto</option>
                    <option>Medio</option>
                    <option>Bajo</option>
                </select>
                
                <label>Radio:</label>
                <input type="number" id="edit_radio" name="radio" required>
                
                <label>Fuente de Información:</label>
                <select id="edit_fuente_informacion" name="fuente_informacion">
                    <option value="Denuncia Ciudadana">Denuncia Ciudadana</option>
                    <option value="Noticia">Noticia</option>
                    <option value="Informe policial">Informe policial</option>
                </select>
            </div>

            <div>
                <label>Estado Delito:</label>
                <select id="edit_estado_delito" name="estado_delito">
                    <option>Reportado</option>
                    <option>En investigación</option>
                    <option>Cerrado</option>
                </select>

                <label>Tipo Delito:</label>
                <select id="edit_tipo_delito" name="tipo_delito" required>
                    <option value="Robo con arma">Robo con arma</option>
                    <option value="Robo de vehículo">Robo de vehículo</option>
                    <option value="Tráfico de drogas">Tráfico de drogas</option>
                    <option value="Agresión sexual">Agresión sexual</option>
                    <option value="Secuestro">Secuestro</option>
                    <option value="Robo a propiedad">Robo a propiedad</option>
                    <option value="Homicidio">Homicidio</option>
                    <option value="Peleas callejeras">Peleas callejeras</option>
                    <option value="Otros">Otros</option>
                </select>

                <label>Fecha y Hora:</label>
                <input type="datetime-local" id="edit_fecha_hora" name="fecha_hora" required>
                
                <label>Latitud Centro:</label>
                <input type="number" step="any" id="edit_latitud_centro" name="latitud_centro" required>
            </div>

            <div class="full-width">
                <label>Longitud Centro:</label>
                <input type="number" step="any" id="edit_longitud_centro" name="longitud_centro" required>
            </div>

            <div class="full-width">
                <label>Descripción:</label>
                <textarea id="edit_descripcion" name="descripcion"></textarea>
            </div>
            
        </div>

        <div class="modal-footer">
            <button type="button" onclick="cerrarModalEditar()" class="bg-red-500 text-white px-3 py-1 rounded">Cancelar</button>
            <button type="submit" class="bg-[#556B2F] text-white px-3 py-1 rounded hover:bg-[#4F6228]">Guardar</button>
        </div>
    </form>
</div>

<script>
function abrirModalEditar(delito) {
    document.getElementById('formEditar').action = `/delitos/${delito.id}`;

    document.getElementById('edit_id').value = delito.id;
    document.getElementById('edit_nombre_zona').value = delito.nombre_zona;
    document.getElementById('edit_nivel_riesgo').value = delito.nivel_riesgo;
    document.getElementById('edit_radio').value = delito.radio;
    document.getElementById('edit_fuente_informacion').value = delito.fuente_informacion;
    document.getElementById('edit_estado_delito').value = delito.estado_delito;
    document.getElementById('edit_tipo_delito').value = delito.tipo_delito;
    document.getElementById('edit_fecha_hora').value = delito.fecha_hora.replace(' ', 'T'); 
    document.getElementById('edit_descripcion').value = delito.descripcion;
    document.getElementById('edit_latitud_centro').value = delito.latitud_centro;
    document.getElementById('edit_longitud_centro').value = delito.longitud_centro;

    document.getElementById('modalBackdrop').style.display = 'block';
    document.getElementById('modalEditar').style.display = 'block';
}

function cerrarModalEditar() {
    document.getElementById('modalBackdrop').style.display = 'none';
    document.getElementById('modalEditar').style.display = 'none';
}

document.getElementById('modalBackdrop').addEventListener('click', cerrarModalEditar);
</script>

<a href="{{ route('mapa.usuario') }}" class="volver-btn">Volver al Mapa</a>

</body>
</html>
