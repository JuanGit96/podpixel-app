<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class CityService
{
    /**
     * Retorna todas las ciudades ordenadas.
     */
    public function getAllCities(): Collection
    {
        return City::orderBy('name', 'asc')->get();
    }

    /**
     * Maneja la lógica de creación de una ciudad.
     */
    public function createCity(array $data, ?UploadedFile $image): City
    {
        if ($image) {
            // Guardamos la imagen en el disco 'public' dentro de la carpeta 'cities'
            $path = $image->store('cities', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        return City::create($data);
    }

    /**
     * Maneja la lógica de actualización.
     */
    public function updateCity(City $city, array $data, ?UploadedFile $image): City
    {
        if ($image) {
            // Eliminamos la imagen anterior si existe y no es una URL externa
            if ($city->image_path && !str_contains($city->image_path, 'http')) {
                $relativePath = str_replace('/storage/', '', $city->image_path);
                Storage::disk('public')->delete($relativePath);
            }

            $path = $image->store('cities', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $city->update($data);
        return $city;
    }

    /**
     * Elimina una ciudad y sus recursos asociados.
     */
    public function deleteCity(City $city): void
    {
        if ($city->image_path && !str_contains($city->image_path, 'http')) {
            $relativePath = str_replace('/storage/', '', $city->image_path);
            Storage::disk('public')->delete($relativePath);
        }
        
        $city->delete();
    }
}