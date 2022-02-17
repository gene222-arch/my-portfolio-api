<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseRequest;

class UpdateRequest  extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'image_url' => ['required', 'string'],
            'website_url' => ['nullable', 'url'],
            'title' => ['required', 'string', "unique:projects,id,{$this->project_id}"],
            'description' => ['required', 'string'],
            'client_feedback' => ['nullable', 'string'],
            'sub_image_urls' => ['required', 'array'],
            'sub_image_urls.*' => ['required', 'string']
        ];
    }
}
