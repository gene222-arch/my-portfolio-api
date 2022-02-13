<?php

namespace App\Http\Requests\Project;

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
            'project_ids' => ['required', 'array'],
            'project_ids.*' => ['required', 'integer', 'distinct', 'exists:projects,id']
        ];
    }
}
