<?php

namespace Modules\Genres\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class GenresRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
           'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'sometimes|boolean',

        ];

        return $rules;

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',
            'status.boolean' => 'Status must be true or false.',

        ];
    }
}
