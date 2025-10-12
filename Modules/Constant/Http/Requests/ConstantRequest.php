<?php

namespace Modules\Constant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConstantRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'value' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'value.required' => 'Value is required.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
