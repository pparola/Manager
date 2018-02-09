<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;


class BajaPagoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pago;

    public function __construct($pago)
    {
        $this->pago = $pago;
    }

    public function build()
    {
      $address = $this->pago->cuota->legajo->EMAIL;
      $subject = 'Constancia de baja de Pago';
      $name = Auth::user()->email;

      return $this->view('pago.pdfBajaPago')
                  ->from($address, $name)
                  ->replyTo($address, $name)
                  ->subject($subject)
                  ->with( 'pago', $this->pago );
    }
}
