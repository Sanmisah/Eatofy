<?php

namespace App\Http\Requests;
use App\Models\Stockist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockistRequest extends FormRequest
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
            'stockist' => 'required|unique:stockists,stockist,'. ($this->stockist ? $this->stockist : ''),
            // 'stockist' => ['required', Rule::unique('stockists')->ignore($this->stockist)],
            'employee_id_1' => 'required',
            'employee_id_2' => 'required',
            'employee_id_3' => 'required',
        ];
    }
    
    public function messages(): array
    {
        return [
            'stockist.required' => 'Stockist name is required',
            'stockist.unique' => 'This name is already exist',
            'employee_id_1' => 'Please select zonal manager',
            'employee_id_2' => 'Please select area manager',
            'employee_id_3' => 'Please select marketing executive',
        ];
    }
}
