<?php

namespace Modules\Currency\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust as per your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency_name' => ['required', 'string', 'max:255'],
            'currency_symbol' => ['required', 'string', 'max:10'],
            'currency_code' => ['required', 'string', 'max:5'],
            'is_primary' => ['nullable', 'boolean'],
            'currency_position' => ['required', 'string', 'in:left,right,left_with_space,right_with_space'],
            'thousand_separator' => ['required', 'string', 'max:1'],
            'decimal_separator' => ['required', 'string', 'max:1'],
            'no_of_decimal' => ['required', 'integer'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'currency_name.required' => 'Currency name is required.',
            'currency_symbol.required' => 'Currency symbol is required.',
            'currency_code.required' => 'Currency code is required.',
            'currency_position.required' => 'Currency position is required.',
            'currency_position.in' => 'Currency position must be one of: left, right, left_with_space, right_with_space.',
            'thousand_separator.required' => 'Thousand separator is required.',
            'decimal_separator.required' => 'Decimal separator is required.',
            'no_of_decimal.required' => 'Number of decimals is required.',
            'no_of_decimal.integer' => 'Number of decimals must be an integer.',
        ];
    }
}
