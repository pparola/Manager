<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use App\Mail\CuentaMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Liquidacion;
use App\Concepto;
use App\Legajo;
use App\Cuota;


class CuotaController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function Cuenta($codigo)
   {

      $titulo = "Cuenta";
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

      return redirect('/cuota/'.$legajo->CODIGO.'/cuenta' )->with($notificacion);

   }

   public function create($codigo){

      $legajo = Legajo::find($codigo);
      $conceptos = Concepto::all();
      $titulo = "Agregar Cuota";

      return view('Cuota.Create')
         ->with('legajo', $legajo)
         ->with('conceptos',$conceptos)
         ->with('titulo', $titulo);

   }

   public function store(Request $request, $codigo){

      $rules = [
         'CONCEPTO'        =>   'required' ,
         'FECHA_1'         =>   'required',
         'IMPORTE_1'       =>   'required',
      ];
      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {
         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput();
      }

      $legajo   = Legajo::find($codigo);
      $concepto = Concepto::find($request->get('CONCEPTO'));
      $fecha    = Carbon::createfromformat( 'd/m/Y', $request->get('FECHA_1'))->format('Y-m-d');

      $codigoLiquidacion = $this->numerar('LIQUIDACIONES');

      $liquidacion = new liquidacion;
      $liquidacion->CODIGO       = $codigoLiquidacion;
      $liquidacion->CONCEPTO     = $request->get('CONCEPTO');
      $liquidacion->ESCUELA      = Auth::user()->CATEGORIA;
      $liquidacion->SUMA_FIJA_1  = 0;
      $liquidacion->VENCIMIENTO_1= $fecha;
      $liquidacion->save();

      $cuota = new Cuota;
      $cuota->CODIGO         = $this->numerar('CUOTAS');
      $cuota->CANCELADO      = 0;
      $cuota->ANO            = 0;
      $cuota->MES            = 0;
      $cuota->CONCEPTO       = $concepto->NOMBRE;
      $cuota->IMPORTE_1      = $request->get('IMPORTE_1');
      $cuota->FECHA_1        = $fecha;
      $cuota->LEGAJO         = $codigo;
      $cuota->LIQUIDACION    = $codigoLiquidacion;
      $cuota->PAGADO         = 0;
      $cuota->save();

      $notificacion = ['message'=>'Registro Agregado!', 'alert-type' => 'success'];

      return redirect('/cuota/'.$codigo.'/cuenta' )->with($notificacion);

   }

   public function delete($codigoCuota)
   {
      $cuota = Cuota::find($codigoCuota);
      return view('Cuota.Delete')
         ->with('titulo', 'Eliminar Cuota')
         ->with('cuota',$cuota);
   }

   public function destroy($codigoCuota){
      $cuota = Cuota::find($codigoCuota);
      $cuota->delete();
      $notificacion = ['message'=>'Baja Realizada... ', 'alert-type' => 'success'];
      return redirect('/cuota/'.$cuota->LEGAJO.'/cuenta' )->with($notificacion);

   }

   public function cambiaremail($codigoLegajo){

      $legajo = Legajo::find($codigoLegajo);

      return view('Cuota.CambiarEmail')
         ->with('titulo', 'Cambiar Email')
         ->with('legajo',$legajo);
   }

   public function cambiaremailstore(Request $request, $codigo){

      $rules = [
         'EMAIL'        =>   'required' ,
      ];
      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {
         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput();
      }

      $legajo   = Legajo::find($codigo);
      $legajo->EMAIL = strtolower( $request->get('EMAIL')) ;
      $legajo->save();

      $notificacion = ['message'=>'Registro modificado!', 'alert-type' => 'success'];

      return redirect('/cuota/'.$codigo.'/cuenta' )->with($notificacion);

   }


}
