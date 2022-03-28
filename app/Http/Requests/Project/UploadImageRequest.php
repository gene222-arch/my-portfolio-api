<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseRequest;

class UploadImageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg']
        ];
    }
}
