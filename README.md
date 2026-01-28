# Prueba Técnica Laravel: Ciudades y Clima (OpenWeatherMap)

Este proyecto es una aplicación web desarrollada en **Laravel 12** (PHP 8.2+) que gestiona un CRUD de ciudades colombianas y consume la API de OpenWeatherMap en tiempo real para visualizar el clima actual.

## 🏗 Arquitectura y Decisiones Técnicas

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

###