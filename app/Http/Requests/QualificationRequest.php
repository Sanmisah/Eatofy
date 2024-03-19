<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QualificationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:qualifications,name,'. ($this->qualification ? $this->qualification->id : ''),
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Qualification name is required',
            'name.unique' => 'Qualification is already exist',
        ];
    }
}
