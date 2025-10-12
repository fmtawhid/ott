<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UserRequest extends FormRequest
{
   public function rules()
    {
        {
            $rules = [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->route('user'))
                ],
                'mobile' => ['required'], 
                'gender' => ['required', 'in:male,female,other'],
                'date_of_birth' => ['required']
            ];


            if ($this->isMethod('post')) {
                $rules['password'] = ['required', 'min:8', 'confirmed'];
            }
    
            return $rules;
        }
    }


    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required.',
            'last_name.required' => 'Last Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'gender.required' => 'Gender is required.',
            'mobile.required' =>'Contact Number is required',
            'gender.in' => 'Please select a valid gender.', // You can customize this message based on your needs
            'date_of_birth.required' =>'Please select a Date of Birth',
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
