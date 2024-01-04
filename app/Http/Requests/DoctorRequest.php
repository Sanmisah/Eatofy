<?php

namespace App\Http\Requests;
use App\Models\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'email' => 'required|unique:doctors,email,'.($this->doctor ? $this->doctor->id : ''),
            'contact_no_1' => 'required',
            'state' => 'required',
            'city' => 'required',
            'territory_id' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'qualification_id' => 'required',
            'speciality' => 'required',
            'mpl_no' => 'required',
            'designation' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'doctor_name.required' => 'Doctor name is required',
            'hospital_name.required' => 'Hospital name is required',
            'email.unique' => 'Already exist email',
            'territory_id.required' => 'Please Select Territory',
            'category_id.required' => 'Please Select Category',
            'type.required' =>  'Please Select type',
            'qualification_id.required' => 'Please Select Qualification',
            'contact_no_1' => 'Please add contact'
        ];
    }
}
