<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'project_id' => 'required|exists:project,id',
            'title' => 'required|string|min:3|max:100',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date'
        ];
    }

    public function message(): array
    {
        return [
            'project_id.required' => 'El proyecto es obligatorio',
            'project_id.exists' => 'El proyecto no existe',
            'title.required' => 'El titulo de la tarea es obligatorio',
            'title.min' => 'El titulo de la tarea debe tener minimo 3 caracteres',
            'title.max' => 'El titulo de la tarea dbee tener máximo 100 caracteres',
            'status.required' => 'El estado de la tarea es obligatorio',
            'status.in' => 'El estado debe ser pending,in_progress,done',
            'priority.required' => 'La prioridad es obligatoria',
            'priority.in' => 'La prioridad debe ser low, medium, high',
            'due_date.required' => 'La fecha limite es obligatoria',
            'due_date.date' => 'Debe ingresar una fecha válida',
        ];
    }
}
