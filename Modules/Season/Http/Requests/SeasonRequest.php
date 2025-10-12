<?php

namespace Modules\Season\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeasonRequest extends FormRequest
{
   public function rules()
    {


        $id = request()->id;
        $rules = [
            'name' => ['required'],
            'entertainment_id'=> ['required'],
            'access'=> ['required'],
            'description' => 'required|string',

        ];
        $movieAccess = $this->input('movie_access');

        if ($movieAccess === 'paid') {
            $rules['plan_id'] = 'required';
        } elseif ($movieAccess === 'pay-per-view') {
            $rules['price'] = 'required|numeric';
            // $rules['discount'] = 'numeric|min:1|max:99';
            $rules['access_duration'] = 'required|integer|min:1';
            $rules['available_for'] = 'required|integer|min:1';
        }

        // if ($this->has('enable_seo') && $this->enable_seo == 1) {
        //     $rules = array_merge($rules, [
        //         'meta_title' => [
        //                 'required',
        //                 'string',
        //                 'max:100',
        //                 Rule::unique('seasons', 'meta_title')->ignore($id),
        //             ],
        //         'google_site_verification' => 'required',
        //         // 'meta_keywords' => 'required',
        //         'meta_keywords' => 'required|max:255',
        //         'canonical_url' => 'required',
        //         'short_description' => 'required|string|max:200',
        //         'seo_image' => 'required',
        //     ]);
        // }

        if ($this->has('enable_seo') && $this->enable_seo == 1) {
            $seasonId = $this->route('season');
            // Handle both array and string cases for route parameter
            if (is_array($seasonId)) {
                $seasonId = $seasonId['id'] ?? null;
            }

        $rules = array_merge($rules, [
            'meta_title' => 'required|string|max:100|unique:seasons,meta_title,' . ($seasonId ?: 'NULL') . ',id',
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
            'name.required' => 'Name is required.',
            'entertainment_id.required' => 'TV Show is required.',
            'access.required' => 'Access is required.',

            'discount.required' => 'Discount is required.',
            'discount.min' => 'Discount must be at least 1%.',
            'discount.max' => 'Discount cannot exceed 99%.',
            'access_duration.integer' => 'Access duration must be a valid number.',
            'access_duration.min' => 'Access duration must be greater than 0.',
            'available_for.integer' => 'Available for must be a valid number.',
            'available_for.min' => 'Available for must be greater than 0.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',

            'meta_title.unique' => 'The meta title has already been taken.',
            // 'meta_title.required' => 'Meta title is required.',
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
