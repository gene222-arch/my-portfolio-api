<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageAdminRequest;
use App\Mail\MessageAdmin;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;

class MessageAdminController extends Controller
{
    public function mail(MessageAdminRequest $request)
    {
        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))
                ->send(
                    new MessageAdmin(
                        $request->email,
                        $request->message,
                        $request->name
                    )
                );

            Email::create($request->validated());
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

        return $this->success('Mail sent successfully.');
    }
}
