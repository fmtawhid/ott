<?php

namespace Modules\Video\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequest extends FormRequest
{
   public function rules()
    {
        $id = request()->id;
        $rules = [
            'name' => ['required'],
            'duration'=> ['required'],
            'access' => 'required',
            // 'release_date' => ['required'],
            'description' => 'required|string',
        ];
            $movieAccess = $this->input('access');

            if ($movieAccess === 'paid') {
                $rules['plan_id'] = 'required';
            } elseif ($movieAccess === 'pay-per-view') {
                $rules['price'] = 'required|numeric';
                // $rules['discount'] = 'numeric|min:1|max:99';
                $rules['access_duration'] = 'required|integer|min:1';
                $rules['available_for'] = 'required|integer|min:1';
            }

        if ($this->has('enable_subtitle') && $this->enable_subtitle == 1) {
            $rules['subtitles'] = 'required|array';
            $rules['subtitles.*.language'] = 'required|string';
            $rules['subtitles.*.subtitle_file'] = 'required|file|mimes:srt,vtt|max:2048';
        }

        if ($this->has('enable_seo') && $this->enable_seo == 1) {
            $videoId = $this->route('video');
            // Handle both array and string cases for route parameter
            if (is_array($videoId)) {
                $videoId = $videoId['id'] ?? null;
            }

        $rules = array_merge($rules, [
            'meta_title' => 'required|string|max:100|unique:videos,meta_title,' . ($videoId ?: 'NULL') . ',id',
            'google_site_verification' => 'required',
            // 'meta_keywords' => 'required',
            'meta_keywords' => 'required|max:255',
            'canonical_url' => 'required',
            'short_description' => 'required|string|max:200',
            'seo_image' => 'required',
        ]);
    }

        return $rules;

    }


    public function messages()
    {
        return [
            'name.required' => 'Title is required.',
            'duration.required' => 'Duration is required.',
            'release_date.required' => 'Release Date is required.',

            'discount.required' => 'Discount is required.',
            'discount.min' => 'Discount must be at least 1%.',
            'discount.max' => 'Discount cannot exceed 99%.',
            'access_duration.integer' => 'Access duration must be a valid number.',
            'access_duration.min' => 'Access duration must be greater than 0.',
            'available_for.integer' => 'Available for must be a valid number.',
            'available_for.min' => 'Available for must be greater than 0.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
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
