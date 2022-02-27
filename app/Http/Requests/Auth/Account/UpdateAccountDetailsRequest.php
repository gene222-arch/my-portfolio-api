<?php

namespace App\Http\Requests\Auth\Account;

use App\Http\Requests\BaseRequest;

class UpdateAccountDetailsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => ['required', 'string']
        ];
    }
}
