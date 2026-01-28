<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\WeatherController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect()->route('cities.index');
});

// Rutas tipo recurso para el CRUD de ciudades
Route::resource('cities', CityController::class)->except(['show']);

//ruta para consultar el clima via AJAX
Route::get('cities/{city}/weather', [WeatherController::class, 'show'])->name('cities.weather');
