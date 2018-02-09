<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Liquidacion;
use App\Concepto;
use App\Legajo;
use App\Cuota;
use App\Pago;

class AjusteController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function index()
   {

      $titulo = "Ajustes";
      $pagos = Pago::where('USUARIO', Auth::user()->id)
                  ->where('CONCEPTO', 'AJUSTE')
                  ->orderBy('FECHA', 'desc')
                  ->get();

      return view('Ajuste.Index')
         ->with('pagos', $pagos)
         ->with('titulo', $titulo);
   }


   public function create($codigoCuota)
   {
      $cuota = Cuota::find($codigoCuota);

      return view('Ajuste.create')
         ->with('titulo', 'Agregar Ajuste')
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

         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput();
      }

      $codigo = $this->numerar('PAGOS');

      $pago = new Pago;
      $pago->CODIGO           = $codigo;
      $pago->CONCEPTO         = 'AJUSTE';
      $pago->CUOTA            = $cuota->CODIGO;
      $pago->IMPORTE          = $request->get('IMPORTE');
      $pago->FECHA            = Carbon::createFromFormat('d/m/Y', $request->get('FECHA'));
      $pago->USUARIO          = Auth::user()->id;
      $pago->save();

      $notificacion = ['message'=>'Registro Agregado!', 'alert-type' => 'success'];

      return redirect( '/cuota/'.$cuota->LEGAJO.'/cuenta' )->with($notificacion);
   }


   public function delete($codigoPago)
   {
      $pago = Pago::find($codigoPago);

      return view('Ajuste.delete')
         ->with('titulo', 'Eliminar Ajuste')
         ->with('pago',$pago);
   }

   public function destroy($codigoPago){

      $pago = Pago::find($codigoPago);
      $fecha = $pago->FECHA;

      $pago->delete();

      $notificacion = ['message'=>'Baja Realizada... ', 'alert-type' => 'success'];

      return redirect( '/ajuste' )->with($notificacion);

   }
}
