<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;


use Illuminate\Http\UploadedFile;

class Email_Work extends Mailable
{
  use Queueable, SerializesModels;

  protected $datos;

  /**
  * Create a new message instance.
  *
  * @return void
  */
  public function __construct($datos)
  {
    $this->datos = $datos;
    //dd($this->datos['imagen']);
  }

  /**
  * Build the message.
  *
  * @return $this
  */
  public function build()
  {

    if ($this->datos['ruta']=='sin archivo') {
      return $this->view('emails.work-nofile')
      ->with('datos',$this->datos)
      ->from('contacto@tienda.printinglab.com');
    }else{
      return $this->view('emails.work-nofile')
      ->with('datos',$this->datos)
      ->attach($this->datos['ruta'])
      ->from('contacto@tienda.printinglab.com');
    }





  }
}
