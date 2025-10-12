<?php

namespace Modules\Filemanager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilemanagerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file_url.*' => 'required|file|mimes:jpeg,jpg,png,gif,mov,mp4,avi',
        ];
    }

    public function messages()
    {
        return [
            'file_url.*.required' => 'File is required.',
            'file_url.*.file' => 'Each file must be a valid file.',
            'file_url.*.mimes' => 'Each file must be a type of: jpeg, jpg, png, gif, mov, mp4, avi.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}

