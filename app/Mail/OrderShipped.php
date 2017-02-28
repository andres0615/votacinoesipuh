<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Persona;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $persona;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Persona $persona)
    {
        $this->persona = $persona;
        //$this->to = $persona->persona_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.rememberpassword');
    }
}
