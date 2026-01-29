<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CityController extends Controller
{
    public function __construct(
        private CityService $cityService
    ) {}
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = $this->cityService->getAllCities();
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $this->cityService->createCity(
            $request->validated(), 
            $request->file('image')
        );

        return redirect()->route('cities.index')
            ->with('success', 'Ciudad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        $this->cityService->updateCity(
            $city, 
            $request->validated(), 
            $request->file('image')
        );

        return redirect()->route('cities.index')
            ->with('success', 'Ciudad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $this->cityService->deleteCity($city);
        
        return redirect()->route('cities.index')
            ->with('success', 'Ciudad eliminada correctamente.');
    }
}
