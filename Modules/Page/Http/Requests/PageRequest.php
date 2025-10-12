<?php

namespace Modules\Page\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
   public function rules()
    {

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name should not exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',
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
