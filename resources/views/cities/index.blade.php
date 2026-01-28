@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Ciudades de Colombia</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($cities as $city)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transform transition hover:scale-105 duration-300">
            <div class="relative">
                <img class="w-full h-48 object-cover" src="{{ asset($city->image_path) }}" alt="{{ $city->name }}">
                <div class="absolute bottom-0 right-0 bg-black bg-opacity-50 text-white px-2 py-1 text-sm">
                    {{ $city->name }}
                </div>
            </div>
            
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-2">{{ $city->name }}</h2>
                    <p class="text-gray-600 text-sm">Lat: {{ number_format($city->latitude, 4) }}</p>
                    <p class="text-gray-600 text-sm">Lon: {{ number_format($city->longitude, 4) }}</p>
                </div>
                
                <div class="mt-4">
                    <button onclick="loadWeather({{ $city->id }}, '{{ $city->name }}')" 
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                        Ver Clima Actual
                    </button>
                </div>
            </div>

            <div class="p-4 bg-gray-50 border-t flex justify-between items-center">
                <a href="{{ route('cities.edit', $city) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">Editar</a>
                <form action="{{ route('cities.destroy', $city) }}" method="POST" onsubmit="return confirm('¿Eliminar ciudad?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Eliminar</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-10 text-gray-500">
            No hay ciudades registradas.
        </div>
    @endforelse
</div>

<div id="weatherModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold" id="modalCityName">Cargando...</h3>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <p id="modalDescription" class="mt-1 text-blue-100 capitalize">...</p>
            </div>

            <div class="px-6 py-6">
                <div id="loadingState" class="flex justify-center py-10">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                </div>

                <div id="weatherContent" class="hidden">
                    <div class="flex items-center justify-center mb-6">
                        <img id="weatherIcon" src="" alt="Icono clima" class="w-24 h-24">
                        <div class="text-6xl font-bold text-gray-800 ml-4">
                            <span id="modalTemp">0</span>°C
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <span class="block text-gray-500 text-xs uppercase tracking-wide">Sensación</span>
                            <span class="block text-lg font-semibold text-gray-800"><span id="modalFeelsLike">0</span>°C</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <span class="block text-gray-500 text-xs uppercase tracking-wide">Humedad</span>
                            <span class="block text-lg font-semibold text-gray-800"><span id="modalHumidity">0</span>%</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <span class="block text-gray-500 text-xs uppercase tracking-wide">Viento</span>
                            <span class="block text-lg font-semibold text-gray-800"><span id="modalWind">0</span> km/h</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <span class="block text-gray-500 text-xs uppercase tracking-wide">Estado</span>
                            <span class="block text-lg font-semibold text-gray-800">Normal</span>
                        </div>
                    </div>
                </div>
                
                <div id="errorState" class="hidden text-center py-4 text-red-600 bg-red-50 rounded">
                    <p>No se pudo cargar la información del clima.</p>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('weatherModal').classList.add('hidden');
    }

    async function loadWeather(cityId, cityName) {
        // 1. Mostrar Modal y Estado de Carga
        const modal = document.getElementById('weatherModal');
        const loading = document.getElementById('loadingState');
        const content = document.getElementById('weatherContent');
        const errorDiv = document.getElementById('errorState');
        
        modal.classList.remove('hidden');
        loading.classList.remove('hidden');
        content.classList.add('hidden');
        errorDiv.classList.add('hidden');
        
        document.getElementById('modalCityName').innerText = cityName;
        document.getElementById('modalDescription').innerText = "Consultando satélite...";

        try {
            // 2. Llamada Fetch al Backend (Laravel)
            const response = await fetch(`/cities/${cityId}/weather`);
            const result = await response.json();

            if (!result.success) throw new Error(result.message);

            const data = result.data;

            // 3. Actualizar DOM con datos
            document.getElementById('modalTemp').innerText = Math.round(data.temp);
            document.getElementById('modalFeelsLike').innerText = Math.round(data.feels_like);
            document.getElementById('modalHumidity').innerText = data.humidity;
            document.getElementById('modalWind').innerText = data.wind_speed;
            document.getElementById('modalDescription').innerText = data.description;
            
            // Icono de OpenWeather
            document.getElementById('weatherIcon').src = `https://openweathermap.org/img/wn/${data.icon}@2x.png`;

            // 4. Mostrar Contenido
            loading.classList.add('hidden');
            content.classList.remove('hidden');

        } catch (error) {
            console.error(error);
            loading.classList.add('hidden');
            errorDiv.classList.remove('hidden');
            document.getElementById('modalDescription').innerText = "Error de conexión";
        }
    }
</script>
@endsection