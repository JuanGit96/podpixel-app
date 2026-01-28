<?php

namespace Tests\Feature;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CityTest extends TestCase
{
    // Resetea la BD después de cada prueba
    use RefreshDatabase;

    /**
     * Prueba que la lista de ciudades carga correctamente.
     */
    public function test_cities_list_can_be_rendered(): void
    {
        City::factory()->create(['name' => 'Medellín']);

        $response = $this->get(route('cities.index'));

        $response->assertStatus(200);
        $response->assertSee('Medellín');
    }

    /**
     * Prueba que se puede crear una ciudad.
     */
    public function test_city_can_be_created(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('bogota.jpg');

        $response = $this->post(route('cities.store'), [
            'name' => 'Bogotá DC',
            'latitude' => 4.7110,
            'longitude' => -74.0721,
            'image' => $file,
        ]);

        $response->assertRedirect(route('cities.index'));
        
        // Verificar que se guardó en BD
        $this->assertDatabaseHas('cities', [
            'name' => 'Bogotá DC',
        ]);

        // Verificar que el archivo existe (hash name)
        // Nota: en el test simple verificamos que exista algún archivo en la carpeta
        $this->assertCount(1, Storage::disk('public')->files('cities'));
    }

    /**
     * Prueba validación de campos requeridos.
     */
    public function test_city_creation_requires_fields(): void
    {
        $response = $this->post(route('cities.store'), []);
        $response->assertSessionHasErrors(['name', 'latitude', 'longitude', 'image']);
    }
}