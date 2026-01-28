<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Validación de archivo
        ];

        // Si es método PUT/PATCH (edición), la imagen no es obligatoria si ya existe
        if ($this->isMethod('post')) {
            $rules['image'][] = 'required';
        }

        return $rules;
    }

    /**
     * Custom messages in Spanish.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la ciudad es obligatorio.',
            'latitude.numeric' => 'La latitud debe ser un número.',
            'image.required' => 'Debes subir una imagen de la ciudad.',
            'image.image' => 'El archivo debe ser una imagen válida.',
        ];
    }
}
