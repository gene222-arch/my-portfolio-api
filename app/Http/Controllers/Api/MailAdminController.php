<?php

namespace App\Http\Controllers\Api;

use App\Models\Email;
use App\Mail\MailAdmin;
use App\Models\PageReport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\MessageAdminRequest;
use App\Models\User;

class MailAdminController extends Controller
{
    public function mail(MessageAdminRequest $request)
    {
        try {
            DB::transaction(function () use ($request) 
            {
                Mail::to(User::first())
                    ->send(
                        new MailAdmin(
                            $request->email,
                            $request->message,
                            $request->name
                        )
                    );

                Email::create($request->validated());
                PageReport::firstOrCreate()->increment('sent_mails');
            });
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

        return $this->success('Mail sent successfully.');
    }
}
