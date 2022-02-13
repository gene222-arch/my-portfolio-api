<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginControllerRequest;
use App\Services\ApiService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this
            ->middleware('guest:api')
            ->except('logout');
    }

    public function login(LoginControllerRequest $request, ApiService $service)
    {
        if (! Auth::attempt($request->safe(['email', 'password'])))
        {
            return $this->error('Login failed, your password is incorrect');
        }

        return $service->token(
            $service->getPersonalAccessToken(),
            'User has logged in successfully.',
            auth()->user()
        );
    }

    public function logout()
    {
        $isTokenRevoked = auth()
            ->user('api')
            ->token()
            ->revoke();

        return !$isTokenRevoked
            ? $this->error('Log out failed')
            : $this->success('User logged out successfully.');
    }
}
