<?php

namespace App\Http\Requests\Testimonial;

use App\Http\Requests\BaseRequest;

class UploadAvatarRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg']
        ];
    }
}
