<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100|unique:projects,name,' . $this->id,
            'description' => 'nullable',
            'status' => 'required|in:active,inactive'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del proyecto es obligatorio',
            'name.unique' => 'Ya existe un proyecto con este nombre',
            'name.min' => 'El nombre debe tener mínimo 3 caracteres',
            'name.max' => 'El nombre debe tener máximo 100 caracteres',
            'status.required' => 'El estado es obligatorio',
            'status.in' => 'El estado debe ser active o inactive'
        ];
    }
}
