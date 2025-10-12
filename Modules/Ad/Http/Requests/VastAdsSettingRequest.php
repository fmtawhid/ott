<?php

namespace Modules\Ad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class VastAdsSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'type' => ['required'],
            'url' => ['required'],
            // 'duration' => ['required'],
            'target_type' => ['required'],
            'target_selection' => ['required'],
            // 'enable_skip' => ['required', 'boolean'],
            // 'skip_after' => ['required_if:enable_skip,1'],
            // 'frequency' => ['required', 'integer'],
            'status' => ['required'],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => [
                'required', 
                'date', 
                'date_format:Y-m-d',
                'after:start_date'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.unique' => 'This ad name has already been taken.',
            'type.required' => 'Type is required.',
            'url.required' => 'URL is required.',
            // 'duration.required' => 'Duration is required.',
            'target_type.required' => 'Target Type is required.',
            'target_selection.required' => 'Target Selection is required.',
            // 'enable_skip.required' => 'Enable Skip is required.',
            // 'skip_after.required_if' => 'Skip After is required', 
            // 'frequency.required' => 'Frequency is required.',
            // 'frequency.integer' => 'Frequency must be a number.',
            'start_date.required' => 'Start Date is required.',
            'start_date.date' => 'Start Date must be a valid date.',
            'start_date.date_format' => 'Start Date must be in YYYY-MM-DD format.',
            'end_date.required' => 'End Date is required.',
            'end_date.date' => 'End Date must be a valid date.',
            'end_date.date_format' => 'End Date must be in YYYY-MM-DD format.',
            'end_date.after' => 'End Date must be after Start Date.',
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
