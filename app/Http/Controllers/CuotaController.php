<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use App\Legajo;
use App\Mail\CuentaMail;
use Illuminate\Support\Facades\Mail;

class CuotaController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function Cuenta($codigo)
   {

      $titulo = "Estado de Cuenta";
      $legajo = Legajo::find($codigo);

      return view('Cuota.Cuenta')
         ->with('legajo', $legajo)
         ->with('titulo', $titulo);
   }

   public function pdfCuenta($codigo)
   {

      $fecha = Carbon::now()->format('dmY');
      $legajo = Legajo::find($codigo);

      $view =  \View::make('Cuota.pdfCuenta', compact('legajo'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);

      return $pdf->download( trim($legajo->NOMBRE).$fecha.'.pdf');
   }

   public function mailCuenta($codigo)
   {
      $legajo = Legajo::find($codigo);

      if($legajo->EMAIL){
         Mail::to($legajo->EMAIL)->send(new CuentaMail($legajo));
         $notificacion = ['message'=>'Email Enviado', 'alert-type' => 'success'];
      } else {
         $notificacion = ['message'=>'No hay mail registrado', 'alert-type' => 'error'];
      }

      return redirect('/cuota/'.$legajo->CODIGO.'/cuenta' );

   }

}
