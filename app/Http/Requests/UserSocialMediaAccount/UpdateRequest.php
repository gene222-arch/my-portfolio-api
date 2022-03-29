<?php

namespace App\Http\Requests\UserSocialMediaAccount;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_social_media_account_id' => ['required', 'integer', 'exists:user_social_media_accounts,id'],
            'name' => ['required', 'alpha', 'unique:user_social_media_accounts,name,' . $this->user_social_media_account_id],
            'email' => ['required', 'email', 'unique:user_social_media_accounts,email,' . $this->user_social_media_account_id],
            'url' => ['required', 'url']
        ];
    }
}
