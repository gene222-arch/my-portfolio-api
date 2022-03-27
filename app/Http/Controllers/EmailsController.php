<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \\Illuminate\Http\JsonResponse
     */
    public function destroy(Email $email)
    {
        $email->delete();

        return $this->success('OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \\Illuminate\Http\JsonResponse
     */
    public function restore(Email $email)
    {
        $email->restore();

        return $this->success('OK');
    }
}
