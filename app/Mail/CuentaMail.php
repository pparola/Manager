<?php

namespace App\Mail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CuentaMail extends Mailable
{
   use Queueable, SerializesModels;

   public $legajo;

   public function __construct($legajo)
   {
      $this->legajo = $legajo;
   }

   public function build()
   {

      $address = $this->legajo->EMAIL;
      $subject = 'Estado de Cuenta Terceros tiempos, Micros y otros Gastos - No incluye Cuota Social';
      $name = Auth::user()->email;

      return $this->view('cuota.pdfCuenta')
                  ->from($address, $name)
                  ->replyTo($address, $name)
                  ->subject($subject)
                  ->with( 'legajo', $this->legajo );



   }
}
