<?php

namespace App\Services;

use App\Traits\HasApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenResult;
use Symfony\Component\HttpFoundation\Response;

class ApiService
{
    use HasApiResponse;

    /**
     * Generate Token
     */
	public function token(
        PersonalAccessTokenResult $token,
        ?string $message = null,
        $data = null,
        int $code = Response::HTTP_OK
    ): \Illuminate\Http\JsonResponse
	{
		$tokenInformation = [
			"access_token" => $token->accessToken,
            "token_type" => "Bearer",
            "expired_at" => Carbon::parse($token->token->expires_at)->toDateTimeString(),
            "data" => $data
		];

		return $this->success($message, $tokenInformation, $code);
	}

    /**
     * Create a new personal access token
     */
    public function getPersonalAccessToken(): PersonalAccessTokenResult
    {
        if (request()->has('remember_me') && request()->remember_me)
        {
            Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(15));
        }

        $key = env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET');

        return auth::user()->createToken($key);
    }
}
