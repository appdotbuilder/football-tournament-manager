<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:3|unique:teams,code',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Team name is required.',
            'code.required' => 'Team code is required.',
            'code.size' => 'Team code must be exactly 3 characters.',
            'code.unique' => 'This team code is already taken.',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a jpeg, png, jpg, gif, or svg file.',
            'logo.max' => 'The logo must not be larger than 2MB.',
        ];
    }
}