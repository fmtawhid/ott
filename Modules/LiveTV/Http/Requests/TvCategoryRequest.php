<?php

namespace Modules\LiveTV\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TvCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
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
