<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Account\UpdateAccountDetailsRequest;
use App\Http\Requests\Auth\Account\UpdateSocialMediaAccountRequest;
use App\Services\UserService;

class AccountController extends Controller
{

    /**
     * @param  \App\Models\User  $user
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $relations = [
            'address',
            'details',
            'socialMediaAccounts'
        ];

        $user = User::with($relations)->find($user->id);

        return $this->success('OK', $user);
    }

    /**
     * @param  \App\Http\Requests\Auth\Account\UpdateAccountDetailsRequest  $request
     * @param  \App\Models\User  $user
     * @param  \App\Services\UserService  $service
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function updateDetails(UpdateAccountDetailsRequest $request, User $user, UserService $service)
    {
        $result = $service->updateDetails(
            $user,
            $request->name,
            $request->email,
            $request->password,
            $request->phone_number,
            $request->address,
            $request->city,
            $request->state,
            $request->zip_code,
            $request->country
        );

        return gettype($result) === 'string'
            ? $this->error($result)
            : $this->success('Account details updated successfully.', $result);
    }

    /**
     * @param  \App\Http\Requests\Auth\Account\UpdateSocialMediaAccountRequest  $request
     * @param  \App\Models\User  $user
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function updateSocialMediaAccount(UpdateSocialMediaAccountRequest $request, User $user)
    {
        $isUpdated = $user->socialMediaAccounts()->update($request->validated());

        return !$isUpdated
            ? $this->error($isUpdated)
            : $this->success('Social media accounts updated successfully.');
    }
}
