<?php

namespace Modules\Subscriptions\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
            $rules = [
                'name' => ['required'],
                'duration' => ['required'],
                'description' => ['required'],
                'duration_value' => ['required', 'numeric', 'min:1'],
                'price' => ['required', 'numeric', 'min:1'],

            ];

            if ($this->isMethod('put')) {
                $rules['level'] = ['required'];
            }

            return $rules;

    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'level.required' =>'Level is required',
            'duration.required' =>'Duration is required',
            'duration_value.required' =>'Duration value is required',
            'duration_value.numeric' => 'Price must be a number.', // Error message for non-numeric price
            'duration_value.min' => 'Price must be at least 1.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.', // Error message for non-numeric price
            'price.min' => 'Price must be at least 1.',
           
        ];
    }
}
