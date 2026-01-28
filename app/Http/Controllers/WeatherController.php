<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(
        private WeatherService $weatherService
    ) {}

    /**
     * Obtiene el clima de una ciudad específica.
     */
    public function show(City $city): JsonResponse
    {
        try {
            $weatherData = $this->weatherService->getWeatherByCoordinates(
                $city->latitude, 
                $city->longitude
            );

            return response()->json([
                'success' => true,
                'data' => $weatherData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener el clima: ' . $e->getMessage()
            ], 500);
        }
    }
}