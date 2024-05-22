<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            '*.name' => 'required|string',
            '*.email' => 'required|email|unique:employees,email',
            '*.password' => 'required|string',
            '*.phone' => 'required|string',
            '*.date_of_birth' => 'required|date',
            '*.role' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            '*.email.unique' => 'The email has already been taken.',
        ];
    }
}
