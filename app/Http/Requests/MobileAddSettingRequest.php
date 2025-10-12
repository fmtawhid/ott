<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobileAddSettingRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required'],
            'type' => ['required'],
        ];
    

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'type.required' => 'Type is required.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
