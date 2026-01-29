# Prueba Técnica Laravel: Ciudades y Clima (OpenWeatherMap)

Este proyecto es una aplicación web desarrollada en **Laravel 12** (PHP 8.2+) que gestiona un CRUD de ciudades colombianas y consume la API de OpenWeatherMap en tiempo real para visualizar el clima actual.

## Arquitectura y Decisiones Técnicas

El proyecto fue construido siguiendo los principios **SOLID** y una arquitectura de capas para asegurar mantenibilidad, escalabilidad y limpieza del código.

### 1. Separación de Responsabilidades (Service Layer Pattern)
Para evitar "Controladores Masivos" (Fat Controllers), se extrajo toda la lógica de negocio e interacción con datos a **Servicios**.
- **Controladores:** Se encargan únicamente de recibir la petición HTTP, validar (vía FormRequests) y devolver una respuesta (Vista o JSON). No contienen lógica de base de datos ni llamadas a APIs.
- **Servicios:**
  - `CityService`: Maneja la creación, actualización y eliminación de ciudades, incluyendo la gestión de imágenes en el sistema de archivos.
  - `WeatherService`: Se encarga exclusivamente de la comunicación con la API externa (OpenWeatherMap), manejo de errores y transformación de datos.

### 2. Validación Robusta
Se utilizaron **Form Requests** (`CityRequest`) para encapsular las reglas de validación, manteniendo el controlador limpio y permitiendo reutilizar validaciones.

### 3. Frontend & UX
- **Blade Components:** Se reutilizó el formulario (`form.blade.php`) para las vistas de creación y edición.
- **JavaScript Moderno:** Se implementó `fetch` con `async/await` para la carga asíncrona del clima, evitando recargas de página y mejorando la experiencia de usuario.
- **Tailwind CSS:** Para un diseño responsivo y limpio.

## 📂 Estructura del Código

A continuación se detalla la ubicación de las clases principales para facilitar la revisión:

| Componente | Archivo | Responsabilidad |
|------------|---------|-----------------|
| **Controlador Web** | `app/Http/Controllers/CityController.php` | Gestiona el CRUD y las vistas (Index, Create, Edit). |
| **Controlador API** | `app/Http/Controllers/WeatherController.php` | Endpoint interno que retorna el clima en JSON. |
| **Servicio DB** | `app/Services/CityService.php` | Lógica de negocio para ciudades e imágenes. |
| **Servicio API** | `app/Services/WeatherService.php` | Cliente HTTP para conectar con OpenWeatherMap. |
| **Request** | `app/Http/Requests/CityRequest.php` | Reglas de validación personalizadas. |
| **Modelo** | `app/Models/City.php` | ORM con propiedades `$fillable` y `$hidden`. |
| **Pruebas** | `tests/Feature/CityTest.php` | Feature tests para validar el flujo completo. |


## Guía de Instalación y Despliegue

Sigue estos pasos detallados para configurar el entorno localmente.

### 1. Clonar el repositorio
Descarga el código fuente y entra en el directorio:

```bash
git clone <url-del-repositorio>
cd <nombre-carpeta>
```

2. Instalar Dependencias

Instala las librerías de PHP necesarias listadas en composer.json:

```bash
composer install
```

3. Configuración del Entorno (.env)

Duplica el archivo de configuración de ejemplo y genera una nueva llave de aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

Abre el archivo .env en tu editor de código y configura:

Base de Datos: Ingresa tus credenciales de MySQL (DB_DATABASE, DB_USERNAME, etc.).
API Key: Agrega tu clave de OpenWeatherMap al final del archivo.

```ini
# Ejemplo en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=laravel_weather
DB_USERNAME=root
DB_PASSWORD=

OPENWEATHER_API_KEY=tu_api_key_aqui
```

4. Base de Datos: Migraciones y Seeders (Crucial)
Este comando es fundamental para iniciar el proyecto con datos.

```bash
php artisan migrate --seed
```

5. Sistema de Archivos: Enlace Simbólico (Storage Link)
Laravel guarda las imágenes subidas en una carpeta privada (storage/app/public) por seguridad. Para que el navegador pueda mostrarlas, debes crear un enlace simbólico a la carpeta pública.

Ejecuta este comando obligatoriamente:

```bash
php artisan storage:link
```

6. Iniciar el Servidor
Todo está listo. Levanta el servidor local:

```bash
php artisan serve
```

Accede a la aplicación en tu navegador: http://127.0.0.1:8000/cities

## Ejecución de Pruebas
El proyecto incluye pruebas automatizadas (Feature Tests) que verifican:

1. Que la lista de ciudades cargue correctamente.
2. Que se pueda crear una ciudad y subir una imagen.
3. Que las validaciones de campos requeridos funcionen.

Para ejecutar las pruebas:

```bash
php artisan test
```

###