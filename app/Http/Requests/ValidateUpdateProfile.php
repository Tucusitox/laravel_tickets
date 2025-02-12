<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUpdateProfile extends FormRequest
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
        return [
            'UserIdentification' => 'required|regex:/^[0-9]{2}[0-9]{3}[0-9]{3}$/',
            'UserGender' => 'required|in:Masculino,Femenino',
            'UserName' => 'required|string|regex:/^[A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]+$/',
            'UserLastName' => 'required|string|regex:/^[A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]+$/',
            'UserDateOfBirth' => 'required|string|regex:/^\d{4}\-\d{2}\-\d{2}$/',
        ];
    }

    /**
     * Mensajes personalizados para las reglas de validación.
     */
    public function messages(): array
    {
        return [
            'UserIdentification.required' => 'La identificación es obligatoria.',
            'UserIdentification.regex' => 'El formato de la identificación es inválido.',

            'UserGender.required' => 'El género es obligatorio.',
            'UserGender.in' => 'Debe seleccionar un género válido.',

            'UserName.required' => 'El nombre es obligatorio.',

            'UserLastName.required' => 'El apellido es obligatorio.',

            'UserDateOfBirth.required' => 'La fecha de nacimiento es obligatoria.',
            'UserDateOfBirth.date' => 'Debe ingresar una fecha válida.',
            'UserDateOfBirth.before_or_equal' => 'La fecha de nacimiento no puede ser en el futuro.',
        ];
    }
}
