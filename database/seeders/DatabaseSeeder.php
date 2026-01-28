<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);

        // Datos reales de ciudades colombianas para pruebas
        $cities = [
            ['name' => 'Bogotá', 'latitude' => 4.7110, 'longitude' => -74.0721],
            ['name' => 'Medellín', 'latitude' => 6.2518, 'longitude' => -75.5636],
            ['name' => 'Cali', 'latitude' => 3.4372, 'longitude' => -76.5225],
            ['name' => 'Barranquilla', 'latitude' => 10.9685, 'longitude' => -74.7813],
            ['name' => 'Cartagena', 'latitude' => 10.3910, 'longitude' => -75.4794],
            ['name' => 'Bucaramanga', 'latitude' => 7.1254, 'longitude' => -73.1198],
            ['name' => 'Pereira', 'latitude' => 4.8133, 'longitude' => -75.6961],
            ['name' => 'Santa Marta', 'latitude' => 11.2408, 'longitude' => -74.1990],
            ['name' => 'Manizales', 'latitude' => 5.0689, 'longitude' => -75.5174],
            ['name' => 'Cúcuta', 'latitude' => 7.8939, 'longitude' => -72.5078],
        ];

        foreach ($cities as $cityData) {
            City::create([
                ...$cityData,
                // Usamos una imagen placeholder por defecto
                'image_path' => 'https://placehold.co/600x400?text=' . $cityData['name']
            ]);
        }
    }
}
