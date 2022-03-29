<?php

namespace App\Http\Requests\UserSocialMediaAccount;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'alpha', 'unique:user_social_media_accounts'],
            'email' => ['required', 'email', 'unique:user_social_media_accounts'],
            'url' => ['required', 'url']
        ];
    }
}
