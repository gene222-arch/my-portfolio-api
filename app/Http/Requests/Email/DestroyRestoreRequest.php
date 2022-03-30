<?php

namespace App\Http\Requests\Email;

use App\Http\Requests\BaseRequest;

class DestroyRestoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:emails,id']
        ];
    }
}
