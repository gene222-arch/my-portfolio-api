<?php

namespace App\Http\Requests\Auth\Account;

use App\Http\Requests\BaseRequest;

class UpdateSocialMediaAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'in:Facebook,Gmail,Twitter,Instagram,LinkedIn'],
            'email' => ['required', 'email', 'unique:user_social_media_accounts'],
            'url' => ['required', 'url']
        ];
    }
}
