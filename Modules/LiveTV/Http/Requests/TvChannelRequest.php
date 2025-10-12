<?php

namespace Modules\LiveTV\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TvChannelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'access' => 'required|in:paid,free',
            'plan_id' => 'required_if:access,paid',
            'description' => 'required|string',


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
     */
    public function authorize(): bool
    {
        return true;
    }
}
