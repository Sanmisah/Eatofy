<?php

namespace App\Http\Requests;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => 'required',  
            'email' => 'required|unique:employees,email,'.($this->employee ? $this->employee->id : ''),
            'contact_no_1' => 'required|numeric|min:10',
            'designation' => 'required',
            'state_name' => 'required',
            'city' => 'required',
            'fieldforce_name' => 'required',
            'dob' => 'required',
            'employee_code' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Employee name is required',
            'email.required' => 'Employee email is required',
            'email.unique' => 'Already exist email',
            'contact_no_1.required' => 'Contact no is required',
            'dob.required' => 'Please add birth date',
            'state_name.required' => 'State is required',
            'designation.required' => 'Select Designation',
        ];
    }
}
