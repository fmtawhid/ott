<?php

namespace Modules\LiveTV\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LiveTVRequest extends FormRequest
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
