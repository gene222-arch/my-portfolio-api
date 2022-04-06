<?php

namespace App\Http\Controllers\Api;

use App\Models\Email;
use App\Mail\MessageAdmin;
use App\Models\PageReport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\MessageAdminRequest;

class MessageAdminController extends Controller
{
    public function mail(MessageAdminRequest $request)
    {
        try {
            DB::transaction(function () use ($request) 
            {
                Mail::to(env('MAIL_FROM_ADDRESS'))
                ->send(
                    new MessageAdmin(
                        $request->email,
                        $request->message,
                        $request->name
                    )
                );

                Email::create($request->validated());
                PageReport::query()->increment('emails_sent');
            });
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

        return $this->success('Mail sent successfully.');
    }
}
