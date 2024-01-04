<?php

namespace App\Http\Requests;
use App\Models\GrantApproval;
use App\Models\Employee;
use App\Models\Activity;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class GrantApprovalRequest extends FormRequest
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
            'email' => 'required',
            'employee_id' => 'required',
            'doctor_id' => 'required',
            'activity_id' => 'required',
            'date_of_issue' => 'required',
            'proposal_amount' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Employee email is required',
        ];
    }
}
