<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("realityinaship@gmail.com")->subject("Verifikasi Email Akun ePKL")->view('emails.email_confirmation')->with(["token" => $this->token]);
    }
}