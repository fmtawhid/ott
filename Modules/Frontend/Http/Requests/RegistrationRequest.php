<?php

namespace Modules\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
   public function rules()
    {

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }


    public function messages()
    {

         return [
             'first_name.required' => 'The first name is required.',
             'last_name.required' => 'The last name is required.',
             'email.required' => 'The email is required.',
             'email.unique' => 'The email has already been taken.',
             'password.required' => 'The password is required.',
             'password.confirmed' => 'The password confirmation does not match.',
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
