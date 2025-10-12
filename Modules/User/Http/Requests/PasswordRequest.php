<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class PasswordRequest extends FormRequest
{
   public function rules()
    {
        {
            $rules = [
                'old_password' => ['required'],
                'password' => ['required', 'min:8', 'confirmed']
            ];
    
            return $rules;
        }
    }


    public function messages()
    {
        return [
       
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'old_password.required' => 'Old password is required.',
         
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
