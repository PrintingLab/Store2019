<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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






}
