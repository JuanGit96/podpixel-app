<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WeatherService
{
    /**
     * URL base de OpenWeatherMap.
     */
    private const API_URL = 'https://api.openweathermap.org/data/2.5/weather';

    /**
     * Consume la API de clima.
     * * @param float $lat
     * @param float $lon
     * @return array
     * @throws Exception
     */
    public function getWeatherByCoordinates(float $lat, float $lon): array
    {
        $apiKey = env('OPENWEATHER_API_KEY');

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get(self::API_URL, [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $apiKey,
                'units' => 'metric', // Convierte Kelvin a Celsius automáticamente
                'lang' => 'es'       // Respuesta en español
            ]);

            if ($response->failed()) {
                Log::error('OpenWeather Error: ' . $response->body());
                throw new Exception('La API externa rechazó la conexión.');
            }

            $data = $response->json();

            return [
                'temp' => round($data['main']['temp']),
                'feels_like' => round($data['main']['feels_like']),
                'humidity' => $data['main']['humidity'],
                'wind_speed' => $data['wind']['speed'],
                'description' => ucfirst($data['weather'][0]['description']),
                'icon' => $data['weather'][0]['icon'],
                'city_name' => $data['name'],
            ];

        } catch (Exception $e) {
            Log::error('Error en servicio de clima: ' . $e->getMessage());
            throw $e;
        }
    }
}