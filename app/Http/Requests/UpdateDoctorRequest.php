<?php

namespace App\Http\Requests;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
            'doctor_name' => 'required', 
            'hospital_name' => 'required',  
            'email' => 'required|unique:doctors,email',
        ];
    }
    public function messages(): array
    {
        return [
            'doctor_name.required' => 'Doctor name is required',
            'hospital_name.required' => 'Hospital name is required',
            'email.unique' => 'Already exist email',
        ];
    }
}
