<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string|max:100',
            'age' => 'required|integer|min:18|max:100',
            'date_of_birth' => 'required|date|before:today',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|regex:/^\+[0-9]+$/',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Employee name is required.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already registered.',
            'position_id.required' => 'Please select a position.',
            'position_id.exists' => 'The selected position is invalid.',
            'department_id.required' => 'Please select a department.',
            'salary.min' => 'Salary must be a positive number.',
            'age.min' => 'Employee must be at least 18 years old.',
            'phone.regex' => 'Phone number must start with + and contain only digits.',
        ];
    }
}
