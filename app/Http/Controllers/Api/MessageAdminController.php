<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageAdminRequest;
use App\Mail\MessageAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageAdminController extends Controller
{
    public function mail(MessageAdminRequest $request)
    {
        Mail::to(env('MAIL_FROM_ADDRESS'))
            ->send(
                new MessageAdmin(
                    $request->email,
                    $request->message,
                    $request->name
                )
            );

        if ($errors = Mail::failures()) {
            return $this->error($errors);
        }

        return $this->success('Mail sent successfully.');
    }
}
