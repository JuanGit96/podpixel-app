@csrf

<div class="mb-4">
    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Ciudad:</label>
    <input type="text" name="name" id="name" 
           value="{{ old('name', $city->name ?? '') }}"
           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
</div>

<div class="flex gap-4">
    <div class="mb-4 w-1/2">
        <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitud:</label>
        <input type="number" step="any" name="latitude" id="latitude" 
               value="{{ old('latitude', $city->latitude ?? '') }}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>
    
    <div class="mb-4 w-1/2">
        <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitud:</label>
        <input type="number" step="any" name="longitude" id="longitude" 
               value="{{ old('longitude', $city->longitude ?? '') }}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>
</div>

<div class="mb-4">
    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagen Representativa:</label>
    <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold
      file:bg-blue-50 file:text-blue-700
      hover:file:bg-blue-100" 
      {{ isset($city) ? '' : 'required' }}>
    
    @if(isset($city) && $city->image_path)
        <div class="mt-2">
            <p class="text-xs text-gray-500">Imagen actual:</p>
            <img src="{{ asset($city->image_path) }}" alt="Preview" class="h-20 w-auto rounded mt-1">
        </div>
    @endif
</div>

<div class="flex items-center justify-between">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
        {{ $btnText }}
    </button>
    <a href="{{ route('cities.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
        Cancelar
    </a>
</div>