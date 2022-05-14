<?php

namespace App\Http\Requests\admin\Attributes;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeRequest extends FormRequest
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
            "code" => "required|unique:attributes,code",
            "name" => "required|string",
            "frontend_type" => "required|in:select,radio,text,textarea",
        ];
    }
}
