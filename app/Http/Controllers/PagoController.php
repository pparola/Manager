<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Cuota;
use App\Pago;
use Illuminate\Support\Facades\Mail;
use App\Mail\PagoMail;
use App\Mail\BajaPagoMail;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function index(Request $request)
   {

      $fecha = $request->get('FECHA');

      if(is_null($fecha)){
         $fecha = Carbon::now()->format('d/m/Y');
      }

      $fechalista = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');

      $titulo = "Pagos";
      $pagos = Pago::where('USUARIO', Auth::user()->id)
                  ->whereDate('FECHA', "=", $fechalista)
                  ->where('CONCEPTO', 'PAGO A CUENTA')
                  ->orderBy('FECHA', 'desc')
                  ->get();

      return view('Pago.Index')
         ->with('pagos', $pagos)
         ->with('titulo', $titulo)
         ->with('FECHA', $fecha);
   }


   public function create($codigoCuota)
   {
      $cuota = Cuota::find($codigoCuota);

      return view('Pago.create')
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
      $pago->CONCEPTO         = 'PAGO A CUENTA';
      $pago->CUOTA            = $cuota->CODIGO;
      $pago->IMPORTE          = $request->get('IMPORTE');
      $pago->FECHA            = Carbon::createFromFormat('d/m/Y', $request->get('FECHA'));
      $pago->USUARIO          = Auth::user()->id;
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

   public function pdfListadoPago($dia, $mes, $anio)
   {

      $fecha = Carbon::create($anio,$mes, $dia)->format('Y-m-d');

      $pagos = Pago::where('USUARIO', Auth::user()->id)
                  ->whereDate('FECHA', "=", $fecha)
                  ->where('CONCEPTO', 'PAGO A CUENTA')
                  ->orderBy('FECHA', 'desc')
                  ->get();

      $view =  \View::make('Pago.pdfListadoPago', compact('pagos', 'fecha'))->render();

      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);

      return $pdf->download( trim(Auth::user()->name).$fecha.'.pdf');
   }

   public function delete($codigoPago)
   {
      $pago = Pago::find($codigoPago);

      return view('Pago.delete')
         ->with('titulo', 'Eliminar Recibo')
         ->with('pago',$pago);
   }

   public function destroy($codigoPago){

      $pago = Pago::find($codigoPago);
      $fecha = $pago->FECHA;

      if($pago->cuota->legajo->EMAIL){


         Mail::to($pago->cuota->legajo->EMAIL)
            ->bcc('p.parola@gmail.com')
            ->send(new BajaPagoMail($pago));

         $pago->delete();

         $notificacion = ['message'=>'Baja Realizada... email enviado', 'alert-type' => 'success'];
      } else {
         $notificacion = ['message'=>'Baja cancelada... no debe tener un mail', 'alert-type' => 'error'];
      }

      return redirect( '/pago?FECHA='.$fecha->format('d/m/Y') )->with($notificacion);

   }


}
