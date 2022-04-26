<?php

namespace App\Mail;

use App\Models\Mails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Captacao extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $mail;
    public function __construct(Mails $mail)
    {
        $this->mail = $mail;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.contacts')->subject('Inscrição feita com sucesso!')->with(
            [
                'name' => $this->mail->name,


            ]
        );
    }
}
