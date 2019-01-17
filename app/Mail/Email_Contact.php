<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email_Contact extends Mailable
{
    use Queueable, SerializesModels;

    protected $datos;
    public function __construct($datos)
    {
        $this->datos=$datos;
    }

    public function build()
    {
        return $this->view('emails.contact-us')
        ->with('datos',$this->datos)
        ->from('contacto@tienda.printinglab.com');
    }
}
