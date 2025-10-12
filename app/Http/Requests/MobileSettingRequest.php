<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobileSettingRequest extends FormRequest
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
            'position' => ['required'],
        ];
    
        if ($this->id == null) {
            $rules['position'][] = 'unique:mobile_settings';
        }
    
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'position.required' => 'Position is required.',
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
