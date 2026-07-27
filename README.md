# Sistema Web Colaborativo de Información de Zonas con Riesgo Delictivo

Proyecto de grado desarrollado por Esteban Moisés Torrez Bustamante.

Aplicación web construida en Laravel que permite visualizar zonas con riesgo delictivo de la ciudad de Cochabamba sobre un mapa interactivo (OpenStreetMap + Leaflet.js), a partir de reportes enviados por los propios ciudadanos y gestionados por las autoridades correspondientes.

## ¿Qué hace el sistema?

Cualquier persona puede enviar un reporte de un incidente delictivo desde un formulario público, adjuntando una descripción y evidencia. Ese reporte queda disponible para que las autoridades lo revisen, editen o eliminen desde un panel de gestión. Toda la información aprobada se muestra en un mapa interactivo, donde además se identifican las zonas con mayor concentración de incidentes (hotspots).

El sistema también incluye un historial de delitos, generación de reportes y un módulo de gestión de usuarios, todo protegido por autenticación (Laravel Breeze).

## Tecnologías

- PHP 8+ / Laravel 12
- Laravel Breeze (autenticación)
- MySQL / MariaDB
- Blade, Tailwind CSS, Alpine.js
- Leaflet.js + OpenStreetMap
- Axios
- Vite

## Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/<tu-usuario>/<tu-repositorio>.git
   cd <tu-repositorio>
   ```

2. Instalar dependencias de backend y frontend:

   ```bash
   composer install
   npm install
   ```

3. Crear una base de datos vacía llamada `sistema_info` (por ejemplo con phpMyAdmin, si usas XAMPP: `http://localhost/phpmyadmin/`). El servidor de MySQL debe estar activo.

4. Copiar el archivo de entorno y configurar la conexión a la base de datos:

   ```bash
   cp .env.example .env
   ```

   Con XAMPP, el usuario suele ser `root` y la contraseña queda vacía:

   ```
   DB_DATABASE=sistema_info
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Generar la clave de la aplicación, enlazar el almacenamiento y correr las migraciones con los seeders:

   ```bash
   php artisan key:generate
   php artisan storage:link
   php artisan migrate --seed
   ```

   Esto crea las tablas y carga el usuario administrador de ejemplo.

## Ejecutar en desarrollo

Se necesitan dos terminales abiertas al mismo tiempo:

```bash
npm run dev        # compila Tailwind y JS, y vigila cambios
```

```bash
php artisan serve  # levanta el servidor de Laravel
```

Con ambos procesos corriendo, la aplicación queda disponible en `http://localhost:8000`.

## Usuario de prueba

El seeder crea el siguiente usuario para poder acceder al sistema apenas se instala:

- Usuario: `useradmintz@gmail.com`
- Contraseña: `adminusertz`

Es solo para desarrollo local. Si el proyecto se llega a desplegar en un entorno real, este usuario debe cambiarse o eliminarse.

## Problemas comunes

- **Los estilos se ven rotos o sin aplicar:** revisa que `npm run dev` esté corriendo.
- **La base de datos no conecta:** confirma el nombre `sistema_info` en el `.env` y que MySQL esté activo.
- **Error 500:** ejecuta `php artisan key:generate` y luego `php artisan optimize:clear`.
- **Problemas con las tablas:** `php artisan migrate:fresh --seed` las elimina y las vuelve a crear desde cero.

## Autor

Esteban Moisés Torrez Bustamante
