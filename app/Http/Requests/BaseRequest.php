<?php

namespace App\Http\Requests;

use App\Traits\HasApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    use HasApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Throws an error response code of 422 with its messages in JSON format
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson())
        {
            $errors = [];
            $errorMessages = $validator->errors()->getMessages();

            foreach ($errorMessages as $key => $value)
            {
                $errors[$key] = $value[array_key_first($value)];
            }

            throw new HttpResponseException(
                $this->error($errors, 422)
            );
        }
    }
}
