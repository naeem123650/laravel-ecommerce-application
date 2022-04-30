<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => [
                'required',
                Password::min(8)->mixedCase()->letters()->symbols()
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email must be required.',
            'email.email' => 'Email must be in proper format.',
            'password.required' => 'Password must be required.'
        ];
    }
}
