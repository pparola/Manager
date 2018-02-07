<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Cuota;
use App\Pago;
use Illuminate\Support\Facades\Mail;
use App\Mail\PagoMail;


class PagoController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function create($codigoCuota)
   {
      $cuota = Cuota::find($codigoCuota);

      return view('Recibo.create')
         ->with('titulo', 'Agregar Recibo')
         ->with('cuota',$cuota);
   }

   public function store(Request $request, $codigoCuota)
   {
      $cuota = Cuota::find($codigoCuota);

      $rules = [
         'IMPORTE'         =>   'required|numeric',
         'FECHA'           =>   'required' ,
      ];
      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {

         $notificacion = ['message'=>'Recibo no ingresado!', 'alert-type' => 'error'];

         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput()
            ->with($notificacion);
      }

      $codigo = $this->numerar('PAGOS');

      $pago = new Pago;
      $pago->CODIGO           = $codigo;
      $pago->CONCEPTO         = $cuota->liquidacion->concepto->NOMBRE;
      $pago->CUOTA            = $cuota->CODIGO;
      $pago->IMPORTE          = $request->get('IMPORTE');
      $pago->FECHA            = Carbon::createFromFormat('d/m/Y', $request->get('FECHA'));
      $pago->save();

      $notificacion = ['message'=>'Registro Agregado!', 'alert-type' => 'success'];

      $pago = Pago::find($codigo);

      if($pago->cuota->legajo->EMAIL){
         Mail::to($pago->cuota->legajo->EMAIL)->send(new PagoMail($pago));
         $notificacion = ['message'=>'Email Enviado', 'alert-type' => 'success'];
      } else {
         $notificacion = ['message'=>'No hay mail registrado', 'alert-type' => 'error'];
      }

      return redirect( '/cuota/'.$cuota->LEGAJO.'/cuenta' )->with($notificacion);
   }


}
