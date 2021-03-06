<?php

namespace App\Http\Requests\Testimonial;

use App\Http\Requests\BaseRequest;

class DestroyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'testimonial_ids' => ['required', 'array'],
            'testimonial_ids.*' => ['integer', 'distinct', 'exists:testimonials,id']
        ];
    }
}
