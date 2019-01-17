<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Email_Work;
use App\Mail\Email_Contact;
use Illuminate\Support\Facades\Mail;


class PagesController extends Controller
{

  public function Aboutus(){
    return view('about-us');
  }
  public function ReturnsRefund(){
    return view('returns-and-refund');
  }
  public function PrivacyPolicy(){
    return view('privacy-policy');
  }
  public function TermsConditions(){
    return view('terms-and-conditions');
  }

  public function ContactUs(){
    return view('/contact-us');
  }


  public function EnviarCorreoContactUs(Request $Request){
    $nombre=$Request->nombre;
    $telefono=$Request->telefono;
    $email=$Request->email;
    $producto=$Request->producto;
    $compania=$Request->compania;
    $comentario=$Request->comentario;
    $emailE='contacto@tienda.printinglab.com';
    $datos=[
      'nombre'=>$nombre,
      'telefono'=>$telefono,
      'email'=>$email,
      'producto'=>$producto,
      'compania'=>$compania,
      'comentario'=>$comentario,
    ];
    Mail::to($emailE)->send(new Email_Contact($datos));

    /*    return view('contact-us');*/
    return back()->with('success_message', 'Message has been sent');
  }





  public function WorkWithUs(){
    return view('work-with-us');
  }

  public function EnviarCorreoWorkWith(Request $Request){
    $nombre= $Request->nombre;
    $telefono=$Request->telefono;
    $email=$Request->email;
    $comentario=$Request->comentario;
    $emailE='jobs@printinglab.com';
    $imagen=$Request->archivo;
    //dd($imagen);
    $select_option=$Request->Job;
    if ($imagen==null) {
      $ruta=('sin archivo');
      $datos= ['nombre' =>$nombre,
      'telefono'=>$telefono,
      'email' =>$email,
      'Options'=>$select_option,
      'comentario' =>$comentario,
      'ruta'=>$ruta
    ];
    Mail::to($emailE)->send(new Email_Work($datos));
    return back()->with('success_message', 'Message has been sent');
  }else {
    $imagen=$Request->file('archivo');
    $nombre_image=$imagen->getClientOriginalName();
    $nombre_imageF=rand(1,9999).'-'.date('H').'-'.date('d').'-'.date('F').'-'.date('Y').'-'.$email.$nombre_image;
    $imagen->move('img-mail/',$nombre_imageF);
    $rutaimg='img-mail/'.$nombre_imageF;
    $datos= ['nombre' =>$nombre,
    'telefono'=>$telefono,
    'email' =>$email,
    'Options'=>$select_option,
    'comentario' =>$comentario,
    'ruta'=>$rutaimg,
  ];
  Mail::to($emailE)->send(new Email_Work($datos));
  return back()->with('success_message', 'Message has been sent');
}


}

}
