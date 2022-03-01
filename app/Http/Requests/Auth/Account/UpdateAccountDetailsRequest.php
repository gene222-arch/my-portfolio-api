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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip_code' => ['required', 'numeric'],
            'country' => ['required', 'string'],
        ];
    }
}
