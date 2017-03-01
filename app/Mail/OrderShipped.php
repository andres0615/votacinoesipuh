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
        $this->from = [
            [
                "address" => "bafdurango1@gmail.com",
                "name" => "Iglesia Pentecostal Unida Hispana .Inc"
            ]
        ];
        $this->subject = "Recordatorio contraseña";
        /*$this->to = [
            [
                "address" => "bafdurango@hotmail.com",
                "name" => "test2"
            ]
        ];*/
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this);
        return $this->view('mail.rememberpassword');
    }
}
