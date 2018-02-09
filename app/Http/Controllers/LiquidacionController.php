<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Liquidacion;
use App\Concepto;
use App\Legajo;
use App\Cuota;

class LiquidacionController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function index(){

      $titulo = "Liquidaciones";
      $liquidaciones = Liquidacion::where('ESCUELA', Auth::user()->CATEGORIA)
                        ->where('SUMA_FIJA_1','>','0')
                        ->orderBy('VENCIMIENTO_1', 'desc')
                        ->get();

      return view('Liquidacion.Index')
         ->with('liquidaciones', $liquidaciones)
         ->with('titulo', $titulo);

   }

   public function create(){
      $titulo = "Nueva Liquidacion";
      $conceptos = Concepto::all();

      return view('Liquidacion.create')
         ->with('conceptos', $conceptos)
         ->with('titulo', $titulo);

   }

   public function store(Request $request)
   {
      $rules = [
         'VENCIMIENTO_1'   =>   'required' ,
         'CONCEPTO'        =>   'required',
         'SUMA_FIJA_1'     =>   'required',
      ];

      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {
         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput();
      }

      $codigoLiquidacion = $this->numerar('LIQUIDACIONES');

      $liquidacion = new Liquidacion;
      $liquidacion->CODIGO      = $codigoLiquidacion;
      $liquidacion->CONCEPTO    = $request->get('CONCEPTO');
      $liquidacion->ESCUELA     = Auth::user()->CATEGORIA;
      $liquidacion->SUMA_FIJA_1 = $request->get('SUMA_FIJA_1');
      $liquidacion->VENCIMIENTO_1 =  Carbon::createFromFormat('d/m/Y', $request->get('VENCIMIENTO_1'));
      $liquidacion->save();

      $conceptoNombre = Concepto::find($request->get('CONCEPTO'))->NOMBRE;

      $legajos = Legajo::where('CURSO', Auth::user()->CATEGORIA)
                  ->where('BAJA', null)
                  ->orderBy('LEGAJO_ESCOLAR')
                  ->get();

      foreach ($legajos as $legajo) {

         $importeCuota = $request->get('SUMA_FIJA_1');
         $descuento = 0;
         if($legajo->DEREXA > 0){
            $descuento = $importeCuota * $legajo->DEREXA /100;
         }


         $cuota = new Cuota;
         $cuota->CODIGO         = $this->numerar('CUOTAS');
         $cuota->CANCELADO      = 0;
         $cuota->ANO            = 0;
         $cuota->MES            = 0;
         $cuota->CONCEPTO       = $conceptoNombre;
         $cuota->IMPORTE_1      = $importeCuota - $descuento;
         $cuota->FECHA_1        =  Carbon::createFromFormat('d/m/Y', $request->get('VENCIMIENTO_1'));
         $cuota->LEGAJO         = $legajo->CODIGO;
         $cuota->LIQUIDACION    = $codigoLiquidacion;
         $cuota->PAGADO         = 0;
         $cuota->save();
      }


      $notificacion = ['message'=>'Registro Agregado!', 'alert-type' => 'success'];

      return redirect( '/liquidacion' )->with($notificacion);
   }

   public function delete($codigo)
   {
      $liquidacion = Liquidacion::find($codigo);

      return view('Liquidacion.delete')
         ->with('liquidacion', $liquidacion)
         ->with('titulo', 'Eliminar Liquidacion');
   }

   public function destroy($codigo)
   {

      $liquidacion = Liquidacion::find($codigo);
      if($liquidacion){

         foreach ($liquidacion->cuotas as $cuota) {
            $cuota->delete();
         }

         $notificacion = ['message'=>'Registro Eliminado!', 'alert-type' => 'success'];
         $liquidacion->delete();
      }else{
         $notificacion = ['message'=>'No existe Registro', 'alert-type' => 'error'];
      }
      return redirect( '/liquidacion' )->with($notificacion);
   }




}
