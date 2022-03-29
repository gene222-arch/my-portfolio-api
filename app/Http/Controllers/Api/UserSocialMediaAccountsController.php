<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSocialMediaAccount\DestroyRequest;
use App\Http\Requests\UserSocialMediaAccount\StoreRequest;
use App\Http\Requests\UserSocialMediaAccount\UpdateRequest;
use App\Models\UserSocialMediaAccount;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserSocialMediaAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success('OK', UserSocialMediaAccount::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserSocialMediaAccount\StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $request
            ->user('api')
            ->socialMediaAccounts()
            ->create($request->validated());

        return $this->success('Social Media Account created successfully.', null, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserSocialMediaAccount\UpdateRequest  $request
     * @param  \App\Models\UserSocialMediaAccount  $socialMediaAccount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, UserSocialMediaAccount $socialMediaAccount)
    {
        $socialMediaAccount->update($request->validated());

        return $this->success('Social Media Accounts updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\UserSocialMediaAccount\UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request)
    {
        UserSocialMediaAccount::whereIn('id', $request->ids)->delete();

        return $this->success('Social Media Accounts deleted successfully.');
    }
}
