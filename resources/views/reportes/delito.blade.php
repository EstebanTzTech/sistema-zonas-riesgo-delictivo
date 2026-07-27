<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Delito</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #556B2F;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .logo {
            width: 120px;
        }
        .title {
            text-align: center;
            font-size: 24px;
            color: #556B2F;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #6B8E23;
        }
        .value {
            margin-bottom: 10px;
            padding: 6px 12px;
            background-color: #f6f6f6;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        
        <div>
            <h2 style="color:#556B2F">Gestión de Delitos</h2>
            <p>Reporte detallado del incidente</p>
        </div>
    </div>

    <div class="section">
        <div class="label">Zona:</div>
        <div class="value">{{ $delito->nombre_zona }}</div>

        <div class="label">Nivel de Riesgo:</div>
        <div class="value">{{ $delito->nivel_riesgo }}</div>

        <div class="label">Radio:</div>
        <div class="value">{{ $delito->radio }} metros</div>

        <div class="label">Fuente de Información:</div>
        <div class="value">{{ $delito->fuente_informacion }}</div>

        <div class="label">Estado del Delito:</div>
        <div class="value">{{ $delito->estado_delito }}</div>

        <div class="label">Tipo de Delito:</div>
        <div class="value">{{ $delito->tipo_delito }}</div>

        <div class="label">Fecha y Hora:</div>
        <div class="value">{{ \Carbon\Carbon::parse($delito->fecha_hora)->format('d/m/Y H:i') }}</div>

        <div class="label">Descripción:</div>
        <div class="value">{{ $delito->descripcion }}</div>

        <div class="label">Coordenadas:</div>
        <div class="value">Latitud: {{ $delito->latitud_centro }} / Longitud: {{ $delito->longitud_centro }}</div>
    </div>

    <p style="text-align: center; margin-top: 40px; font-size: 12px; color: #888">
        Generado automáticamente por el sistema cocha segura map- {{ now()->format('d/m/Y H:i') }}
    </p>
</body>
</html>

