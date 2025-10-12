<?php

namespace Modules\World\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorldRequest extends FormRequest
{
   public function rules()
    {

        return [
            'name' => ['required'],
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
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
