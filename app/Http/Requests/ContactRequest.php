<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
           // 'user_id' => 'required|numeric',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',//|max:10',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' =>'required|numeric|min:4',
            'date_of_birth' => 'required|date',
        ];
    }

    // You can also customize messages for each rule
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 20 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.numeric' => 'The phone number must be a number.',
            //'phone_number.min' => 'The phone number must be at least 10 digits.',
            //'phone_number.max' => 'The phone number must not exceed 10 digits.',
            'street_address.required' => 'The street address field is required.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
            'zip_code.required' => 'The ZIP code field is required.',
            'zip_code.numeric' => 'The ZIP code must be a number.',
            'zip_code.min' => 'The ZIP code must be at least 4 digits.',
           // 'zip_code.max' => 'The ZIP code must not exceed 6 digits.',
            'date_of_birth.required' => 'The date of birth field is required.',
            'date_of_birth.date' => 'Please enter a valid date of birth.',
        ];
    }
}
