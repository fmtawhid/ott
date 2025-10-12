<?php

namespace Modules\Subscriptions\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlanLimitationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'title' => ['required'],
            'description' => ['required'],
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
            'title.required' => 'Title is required.',
            'description.required' =>'Description is required',

        ];
    }
}
