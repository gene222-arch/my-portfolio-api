<?php

namespace App\Http\Controllers;

use App\Http\Requests\Email\DestroyRestoreRequest;
use App\Models\Email;
use Illuminate\Http\Request;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $emailQuery = Email::query();

        if (request()->has('archives')) {
            $emailQuery = $emailQuery->onlyTrashed();
        }

        $emails = $emailQuery->orderByDesc('created_at')->get();

        return $this->success('OK', $emails);
    }

    /**
     * Remove the multiple resource from storage.
     *
     * @param  \App\Http\Requests\Email\DestroyRestoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRestoreRequest $request)
    {
        Email::whereIn('id', $request->ids)->delete();

        return $this->success('OK');
    }

    /**
     * Restore multiple resource from storage.
     *
     * @param  \App\Http\Requests\Email\DestroyRestoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(DestroyRestoreRequest $request)
    {
        Email::withTrashed()
            ->whereIn('id', $request->ids)
            ->restore();

        return $this->success('OK');
    }
}
