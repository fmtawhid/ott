<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch (strtolower(request()->method())) {
            case 'post':
                return [
                    'first_name' => ['required'],
                    'last_name' => ['required'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                    'mobile' => ['required'],
                    'password' => ['required'],
                    'password_confirmation' => ['required'],
                    'gender' => ['required'],
                    'date_of_birth' => ['required'],
                ];
                break;
            case 'put':
            case 'patch':
                return [
                    'first_name' => ['required'],
                    'last_name' => ['required'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                    'mobile' => ['required','unique:users,mobile'],
                    'gender' => ['required'],
                    'date_of_birth' => ['required'],
                ];
                break;

            default:
                // code...
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $data = [
            'status' => false,
            'message' => $validator->errors()->first(),
            'all_message' => $validator->errors(),
        ];

        if (request()->wantsJson() || request()->is('api/*')) {
            throw new HttpResponseException(response()->json($data, 422));
        }

        throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
    }
}
