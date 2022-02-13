<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class LoginControllerRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'string', 'min:8'],
            'remember_me' => ['required',  'boolean']
        ];
    }
}
