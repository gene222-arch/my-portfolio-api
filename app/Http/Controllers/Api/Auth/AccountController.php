<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Account\UpdateAccountDetailsRequest;
use App\Http\Requests\Auth\Account\UpdateSocialMediaAccountRequest;

class AccountController extends Controller
{
    /**
     * @param  \App\Http\Requests\Auth\Account\UpdateAccountDetailsRequest  $request
     * @param  \App\Models\User  $user
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function updateDetails(UpdateAccountDetailsRequest $request, User $user)
    {
        $isUpdated = $user->details()->update($request->validated());

        return !$isUpdated
            ? $this->error($isUpdated)
            : $this->success('Account details updated successfully.');
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
