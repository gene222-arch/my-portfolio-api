<?php

namespace App\Http\Requests\Testimonial;

use App\Http\Requests\BaseRequest;

class StoreUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'avatar_url' => ['required', 'url'],
            'body' => ['required', 'string'],
            'profession' => ['required', 'string'],
            'rate' => ['required', 'numeric']
        ];
    }
}
