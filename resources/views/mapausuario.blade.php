<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mapa Interactivo de Delitos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    #map {
        height: 600px;
    }

    /* Título  */
    .header-container {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    /*  Línea del título  */
    .header-container h1 {
        background: linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(255, 255, 255) 100%);
        background-clip: text;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        padding: 20px 40px 10px 40px;
        background-color: #fff;
        border-radius: 15px;
        position: relative;
        z-index: 2;
        display: inline-block;
    }

    /* Línea decorativa centrada justo debajo del texto */
    .header-container h1::after {
        content: '';
        display: block;
        width: 120px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #ffffff, transparent);
        margin: 10px auto 0 auto;
        border-radius: 3px;
    }

    .subtitle {
        color: #ffffff;
        font-size: 1.1rem;
        margin-top: 10px;
        font-weight: 300;
    }

    /*  Descripción corta   */
    .descripcion-corta {
        font-size: 1rem;
        max-width: 750px;
        margin: 20px auto 10px auto;
        color: #f0f0f0;
        line-height: 1.6;
        text-align: center;
        background: rgba(255, 255, 255, 0.08);
        padding: 12px 18px;
        border-radius: 10px;
        backdrop-filter: blur(3px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    /*  Instrucciones del mapa  */
    .instrucciones-mapa {
        background: rgba(255, 255, 255, 0.12);
        border-left: 4px solid #ffcc00;
        padding: 10px 15px;
        margin: 20px auto 25px auto;
        max-width: 700px;
        text-align: left;
        border-radius: 6px;
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 0.9em;
    }

    .instrucciones-mapa strong {
        color: #ffeb3b;
        display: block;
        margin-bottom: 5px;
    }

    .instrucciones-mapa ul {
        padding-left: 20px;
        margin: 0;
        color: #f5f5f5;
    }

    .instrucciones-mapa li {
        margin-bottom: 5px;
    }

    /*  Estilo principal   */
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

    #searchContainer {
        margin: 10px auto;
        max-width: 600px;
        text-align: center;
    }

    #searchInput {
        width: 70%;
        padding: 10px;
        font-size: 15px;
        border: 2px solid #ccc;
        border-radius: 6px;
        background-color: #fff;
        color: #000;
    }

    #searchContainer button {
        padding: 10px 20px;
        margin-left: 10px;
        font-size: 15px;
        font-weight: bold;
        background-color: rgb(104, 124, 47);
        color: white;
        border: 2px solid white;
        border-radius: 6px;
        cursor: pointer;
    }

    #searchContainer button:hover {
        background-color: rgb(155, 185, 71);
    }

    #formModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border: 2px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        z-index: 1000;
        max-width: 600px;
        font-family: Arial, sans-serif;
    }

    #formModal h3 {
        margin: 0 0 10px 0;
        padding: 10px;
        background: #556B2F;
        color: white;
        border-radius: 5px;
        text-align: center;
        cursor: move;
        user-select: none;
    }

    .form-grid {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-column {
        flex: 1 1 45%;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-column label {
        font-weight: bold;
        color: #333;
    }

    .form-column input,
    .form-column select,
    .form-column textarea {
        margin-top: 5px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .form-buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .form-buttons button[type="submit"] {
        background: #556B2F;
        color: white;
    }

    .form-buttons button[type="submit"]:hover {
        background: #4F6228;
    }

    .form-buttons button[type="button"] {
        background: #f44336;
        color: white;
    }

    .form-buttons button[type="button"]:hover {
        background: #da190b;
    }

    .legend {
        background: #ffffff;
        color: #333;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin: 30px auto;
        max-width: 700px;
        font-size: 14px;
        font-family: Arial, sans-serif;
        text-align: center;
        overflow: hidden;
    }

    .legend h4 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 16px;
        color: rgb(3, 39, 5);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Segoe UI', sans-serif;
    }

    #estadisticasDelitos {
        margin-top: 20px;
        text-align: left;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }

    #estadisticasDelitos div {
        padding: 8px 0;
        border-bottom: 1px dashed #ccc;
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        word-wrap: break-word;
        word-break: break-word;
    }
</style>


</head>

<body>
    @include('layouts.navigation')

    <div class="header-container">
    <h1>MAPA DE DELITOS</h1>
    <p class="subtitle">Sistema de Monitoreo y Seguimiento de Incidentes Delictivos</p>
    <p class="descripcion-corta">
        Este mapa interactivo permite explorar la ciudad de Cochabamba y localizar los puntos donde se han reportado delitos.
        Los usuarios pueden navegar libremente, acercar o alejar la vista, y registrar nuevos incidentes haciendo clic directamente sobre la ubicación correspondiente en el mapa.
    </p>
    <div class="instrucciones-mapa">
        <strong>🛈 Instrucciones de uso:</strong>
        <ul>
            <li>Utiliza la barra de búsqueda para encontrar calles, avenidas o zonas específicas.</li>
            <li>Haz clic en el mapa sobre la ubicación donde ocurrió un delito para registrar un nuevo reporte.</li>
            <li>Puedes acercar o alejar el mapa usando los controles del lado izquierdo.</li>
        </ul>
    </div>
</div>

<div id="searchContainer">
    <input type="text" id="searchInput" placeholder="Buscar calles, avenidas o lugares en Cochabamba..." />
    <button onclick="buscarDireccion()">Buscar</button>
</div>

<div id="map-container">
    <div id="map" style="height: 500px;"></div>
</div>

<div id="filterContainer" style="margin: 10px auto; max-width: 800px; text-align: center; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
    <select id="filterSelect" style="padding: 10px; font-size: 15px; border: 2px solid #ccc; border-radius: 6px; background: #fff; color: #000; min-width: 220px;">
        <option value="todos">Mostrar Todos los Delitos</option>
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

    <button onclick="filtrarDelitos()" style="padding: 10px 20px; font-size: 15px; font-weight: bold; background-color:rgb(104, 124, 47); color: white; border: 2px solid white; border-radius: 6px; cursor: pointer;">
        Filtrar
    </button>

    <button onclick="toggleHotspots()" style="padding: 10px 20px; font-size: 15px; font-weight: bold; background-color:rgb(85, 107, 47); color: white; border: 2px solid white; border-radius: 6px; cursor: pointer;">
        Mostrar/Ocultar Hotspots
    </button>
</div>



    <div class="legend" id="legend">
        <h4 style="text-align:center">ESTADÍSTICAS DE DELITOS</h4>
        <canvas id="graficoDelitos"></canvas>
        <div id="estadisticasDelitos"></div>
    </div>

    <div id="formModal">
        <form id="zonaForm">
            <h3>Registrar Zona y Delito</h3>
            <div class="form-grid">
                <div class="form-column">
                    <label>Nombre de zona:
                        <input type="text" name="nombre_zona" required>
                    </label>
                    <label>Nivel de riesgo:
                        <select name="nivel_riesgo">
                            <option>Alto</option>
                            <option>Medio</option>
                            <option>Bajo</option>
                        </select>
                    </label>
                    <label>Radio (m):
                        <input type="number" name="radio" required>
                    </label>
                    <label>Fuente de información:
                        <select name="fuente_informacion" required>
                            <option value="" disabled selected>Seleccionar fuente de información</option>
                            <option value="Denuncia Ciudadana">Denuncia Ciudadana</option>
                            <option value="Noticia">Noticia</option>
                            <option value="Informe policial">Informe policial</option>
                        </select>
                    </label>
                    <label>Estado del delito:
                        <select name="estado_delito" required>
                            <option value="" disabled selected>Seleccionar estado del delito</option>
                            <option value="Reportado">Reportado</option>
                            <option value="En investigación">En investigación</option>
                            <option value="Cerrado">Cerrado</option>
                        </select>
                    </label>  
                </div>
                <div class="form-column">
                    <label>Tipo de delito:
                        <select name="tipo_delito" required>
                            <option value="">Seleccionar tipo de delito</option>
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
                    </label>
                    <label>Fecha y hora:
                        <input type="datetime-local" name="fecha_hora" required>
                    </label>
                    <label>Descripción:
                        <textarea name="descripcion" rows="3"></textarea>
                    </label>
                </div>
            </div>
            <div class="form-buttons">
                <input type="hidden" name="latitud_centro">
                <input type="hidden" name="longitud_centro">
                <button type="submit">Guardar</button>
                <button type="button" onclick="cerrarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-17.3895, -66.1568], 13);
        // Revisar si hay parámetros lat y lng en la URL
const urlParams = new URLSearchParams(window.location.search);
const latParam = urlParams.get('lat');
const lngParam = urlParams.get('lng');

// Si existen, centrar el mapa en esa ubicación con un zoom adecuado
if (latParam && lngParam) {
    const lat = parseFloat(latParam);
    const lng = parseFloat(lngParam);
    if (!isNaN(lat) && !isNaN(lng)) {
        map.setView([lat, lng], 17); // Zoom más cercano
    }
}

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const markers = [];

        function getColorByCrimeType(tipo) {
            const colores = {
                "Robo con arma": "red",
                "Robo de vehículo": "blue",
                "Tráfico de drogas": "purple",
                "Agresión sexual": "pink",
                "Secuestro": "gray",
                "Robo a propiedad": "yellow",
                "Homicidio": "black",
                "Peleas callejeras": "orange",
                "Otros": "green"
            };
            return colores[tipo] || "gray";
        }

        function createColoredDivIcon(color) {
            return L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="width: 24px; height: 24px; background: ${color}; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 2px solid #555;"></div>`,
                iconSize: [30, 42],
                iconAnchor: [15, 42],
                popupAnchor: [0, -40]
            });
        }

        function addMarker(lat, lng, data) {
            const color = getColorByCrimeType(data.tipo_delito);
            const marker = L.marker([lat, lng], { icon: createColoredDivIcon(color) }).addTo(map);
            markers.push({ marker, tipo: data.tipo_delito });

            const popupContent = `
                <strong>${data.nombre_zona}</strong><br>
                <b>Tipo de delito:</b> ${data.tipo_delito}<br>
                <b>Nivel de riesgo:</b> ${data.nivel_riesgo}<br>
                <b>Descripción:</b> ${data.descripcion}<br>
                <b>Fecha y hora:</b> ${data.fecha_hora}<br>
                <b>Fuente:</b> ${data.fuente_informacion}<br>
                <b>Estado del delito:</b> ${data.estado_delito}
            `;
            marker.bindPopup(popupContent);
        }

        function calcularDistanciaKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2 +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) ** 2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }

        const hotspotCircles = [];

            function detectarHotspots() {
                markers.forEach((m1) => {
                    const grupo = [m1];
                    markers.forEach((m2) => {
                        if (m1 !== m2) {
                            const d = calcularDistanciaKm(
                                m1.marker.getLatLng().lat, m1.marker.getLatLng().lng,
                                m2.marker.getLatLng().lat, m2.marker.getLatLng().lng
                            );
                            if (d <= 1) {
                                grupo.push(m2);
                            }
                        }
                    });
                    if (grupo.length >= 3) {
                        const lat = grupo.reduce((sum, m) => sum + m.marker.getLatLng().lat, 0) / grupo.length;
                        const lng = grupo.reduce((sum, m) => sum + m.marker.getLatLng().lng, 0) / grupo.length;
                        
                        const circle = L.circle([lat, lng], {
                            color: '#cc0000',
                            fillColor: '#ff4d4d',
                            fillOpacity: 0.15,
                            weight: 4,
                            radius: 1000,
                            opacity: 0.7,
                            dashArray: '5, 10'
                        }).addTo(map);

                        hotspotCircles.push(circle);
                    }
                });
            }



        let chartDelitos;
        function actualizarEstadisticas() {
            const contador = {}, total = markers.length;
            markers.forEach(({ tipo }) => {
                contador[tipo] = (contador[tipo] || 0) + 1;
            });

            const ctx = document.getElementById('graficoDelitos').getContext('2d');
            const labels = Object.keys(contador);
            const datos = Object.values(contador);
            const colores = labels.map(getColorByCrimeType);

            if (chartDelitos) chartDelitos.destroy();
            chartDelitos = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{ data: datos, backgroundColor: colores }]
                },
                options: { plugins: { legend: { position: 'bottom' } } }
            });

            const contenedor = document.getElementById("estadisticasDelitos");
            contenedor.innerHTML = '';
            labels.forEach((delito, i) => {
                const porcentaje = ((datos[i] / total) * 100).toFixed(1);
                contenedor.innerHTML += `<div><strong>${delito}:</strong> ${datos[i]} (${porcentaje}%)</div>`;
            });
        }

        fetch("{{ route('mapa.markers') }}")
            .then(res => res.json())
            .then(data => {
                data.forEach(marker => {
                    addMarker(marker.latitud_centro, marker.longitud_centro, marker);
                });
                detectarHotspots();
                actualizarEstadisticas();
            });

        map.on('click', function(e) {
            abrirFormulario(e.latlng.lat, e.latlng.lng);
        });

        document.getElementById('zonaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch("{{ route('mapa.guardar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            }).then(() => {
                document.getElementById('formModal').style.display = 'none';
                addMarker(data.latitud_centro, data.longitud_centro, data);
                detectarHotspots();
                actualizarEstadisticas();
            });
        });
function filtrarDelitos() {
    const filtro = document.getElementById('filterSelect').value;
    markers.forEach(({ marker, tipo }) => {
        if (filtro === 'todos' || tipo === filtro) {
            if (!map.hasLayer(marker)) {
                marker.addTo(map);
            }
        } else {
            if (map.hasLayer(marker)) {
                map.removeLayer(marker);
            }
        }
    });
}

let hotspotsVisibles = true;
function toggleHotspots() {
    hotspotsVisibles = !hotspotsVisibles;
    hotspotCircles.forEach(circle => {
        if (hotspotsVisibles) {
            circle.addTo(map);
        } else {
            map.removeLayer(circle);
        }
    });
}

        function buscarDireccion() {
            const query = document.getElementById("searchInput").value;
            if (!query) return alert("Escribe una dirección en Cochabamba.");
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Cochabamba, Bolivia')}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        map.setView([data[0].lat, data[0].lon], 17);
                    } else {
                        alert("No se encontró el lugar.");
                    }
                })
                .catch(() => alert("Error al buscar la dirección."));
        }

        function cerrarFormulario() {
            document.getElementById('formModal').style.display = 'none';
            document.getElementById('zonaForm').reset();
            document.querySelector('input[name="latitud_centro"]').value = '';
            document.querySelector('input[name="longitud_centro"]').value = '';
        }

        function abrirFormulario(lat, lng) {
            const formModal = document.getElementById('formModal');
            formModal.style.display = 'block';
            document.getElementById('zonaForm').reset();
            document.querySelector('input[name="latitud_centro"]').value = lat;
            document.querySelector('input[name="longitud_centro"]').value = lng;
            // Reset modal position to center
            formModal.style.transform = 'translate(-50%, -50%)';
            formModal.style.left = '50%';
            formModal.style.top = '50%';
        }

        // Drag functionality for form modal
        const formModal = document.getElementById('formModal');
        const formHeader = formModal.querySelector('h3');
        let isDragging = false;
        let initialX;
        let initialY;
        let offsetX = 0;
        let offsetY = 0;

        formHeader.addEventListener('mousedown', startDragging);

        function startDragging(e) {
            const rect = formModal.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
            isDragging = true;
            formModal.style.transition = 'none'; // Disable transition during drag
        }

        document.addEventListener('mousemove', drag);

        function drag(e) {
            if (isDragging) {
                e.preventDefault();
                const x = e.clientX - offsetX;
                const y = e.clientY - offsetY;
                formModal.style.left = '0';
                formModal.style.top = '0';
                formModal.style.transform = `translate(${x}px, ${y}px)`;
            }
        }

        document.addEventListener('mouseup', stopDragging);

        function stopDragging() {
            isDragging = false;
            formModal.style.transition = 'transform 0.2s ease-out'; // Re-enable transition
        }
    </script>
</body>

</html>
