<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id'  => 'required|exists:services,id',
            'id_coiffeur' => 'required|exists:users,id',
            'date'        => 'required|date|after_or_equal:today',
            'heure'       => 'required|string|regex:/^\d{2}:\d{2}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required'  => 'Veuillez sélectionner un service.',
            'service_id.exists'    => 'Service invalide.',
            'id_coiffeur.required' => 'Veuillez sélectionner un coiffeur.',
            'id_coiffeur.exists'   => 'Coiffeur invalide.',
            'date.required'        => 'Veuillez choisir une date.',
            'date.after_or_equal'  => 'La date doit être aujourd\'hui ou dans le futur.',
            'heure.required'       => 'Veuillez choisir une heure.',
        ];
    }
}
