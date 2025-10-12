<?php

namespace Modules\Entertainment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Return true if the user is authorized to make the request, or implement your authorization logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'video_url_input' => 'required|string|max:255',
            'movie_access' => 'required|string|in:free,pay-per-view',
            'video_quality_type' => 'nullable|array',
            'video_quality_type.*' => 'in:URL,Embedded', // Assuming "URL" or "Embedded" are valid types
            'quality_video_url_input' => 'nullable|array',
            'quality_video_url_input.*' => 'nullable|url|max:255',
            'quality_video_embed_input' => 'nullable|array',
            'quality_video_embed_input.*' => 'nullable|string',
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [


            'video_url_input.required' => 'The video URL input is required.',
            'movie_access.required' => 'The movie access field is required.',
            'movie_access.in' => 'The movie access field must be either "free" or "pay-per-view".',

            'video_quality_type.array' => 'The video quality types must be an array.',
            'video_quality_type.*.in' => 'Each video quality type must be either "URL" or "Embedded".',
            'quality_video_url_input.array' => 'The video quality URL input must be an array.',
            'quality_video_url_input.*.url' => 'Each video URL input must be a valid URL.',
            'quality_video_embed_input.array' => 'The video quality embed input must be an array.',
            'quality_video_embed_input.*.string' => 'Each video embed input must be a valid string.',
        ];
    }

    /**
     * Prepare the data for the store method.
     *
     * @return array
     */

}
