<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $email;
    public string $messageContent;
    public string $name;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $messageContent, string $name)
    {
        $this->email = $email;
        $this->messageContent = $messageContent;
        $this->name = $name;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, $this->name)
            ->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Message from Portfolio')
            ->markdown('mails.message-admin');
    }
}
