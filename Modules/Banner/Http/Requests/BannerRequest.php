<?php

namespace Modules\Banner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
   public function rules()
    {

        return [
            'type' => 'required|string|in:movie,tvshow,livetv,video',
            'name_id' => 'required',
           
        ];
    }


    public function messages()
    {
        return [
            'type.required' => 'Type is required.',
            'name_id.required' => 'Name is required.',
          
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
