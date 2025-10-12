<?php

namespace Modules\SEO\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // dd(request()->all());
        return [
             'meta_title' => 'nullable|string|max:255',
        // 'meta_keywords' => 'required|string',
        'meta_description' => 'nullable|string',
        'google_site_verification' => 'nullable|string|max:255',
        'short_description' => 'required|string',   //  MUST be here
        'canonical_url' => 'required|string',       //  MUST be here (or use 'url')
        // 'seo_image_input' => 'required|string',
            'seo_image' => 'required|string', // Image validation
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
