<?php

namespace Modules\CastCrew\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class CastCrewRequest extends FormRequest
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
            'bio' => ['required'],
            'type' => ['required'],
            'dob' => ['required'],
            'place_of_birth' => ['required'],
        
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
            'bio.required' =>'Bio is required',
            'type.required' =>'Type is required',
            'dob.required' =>'Date Of Birth is required',
            'place_of_birth.required'=>'Place Of Birth required'

        ];
    }
}
