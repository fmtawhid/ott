<?php

namespace Modules\FAQ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FAQRequest extends FormRequest
{
   public function rules()
    {

        return [
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
