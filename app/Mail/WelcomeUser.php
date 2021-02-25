<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public $nombre ;
    public $contrasena;

    public function __construct($nombre,$contrasena)
    {
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->view("mails/welcome")
            ->from("these08@gmail.com",'TRANSCAPITAL')
            ->subject("Bienvenido a TRANSCAPITAL - ".$this->nombre);

    }
}
