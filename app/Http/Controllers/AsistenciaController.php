<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Fecha;
use App\Asistencia;
use App\Legajo;
use Carbon\Carbon;


class AsistenciaController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

   public function index(){
      $titulo = "Asistencia";
      $fechas = Fecha::where('CATEGORIA', Auth::user()->CATEGORIA)
                        ->get();
      return view('Asistencia.Index')
         ->with('fechas', $fechas)
         ->with('titulo', $titulo);
   }

   public function create(){
      $titulo = "Asistencia";
      return view('Asistencia.create')
         ->with('titulo', $titulo);
   }


   public function store(Request $request)
   {
      $rules = [
         'FECHA'          =>   'required' ,
         'OBSERVA'        =>   'required',
      ];

      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {
         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput();
      }

      $codigoFecha = $this->numerar('FECHAS');

      $fecha = new Fecha;
      $fecha->CODIGO      = $codigoFecha;
      $fecha->FECHA       = Carbon::createfromformat('d/m/Y', $request->get('FECHA'));
      $fecha->OBSERVA     = $request->get('OBSERVA');
      $fecha->CATEGORIA   = Auth::user()->CATEGORIA;
      $fecha->save();

      $legajos = Legajo::where('CURSO', Auth::user()->CATEGORIA)
                  ->where('BAJA', null)
                  ->orderBy('LEGAJO_ESCOLAR')
                  ->get();

      foreach ($legajos as $legajo) {


         $asistencia = new Asistencia;
         $asistencia->CODIGO         = $this->numerar('ASISTENCIAS');
         $asistencia->FECHA          = $codigoFecha;
         $asistencia->LEGAJO         = $legajo->CODIGO;
         $asistencia->PRESENTE       = 0;
         $asistencia->save();
      }

      $notificacion = ['message'=>'Registro Agregado!', 'alert-type' => 'success'];

      return redirect( '/asistencia/'.$codigoFecha.'/edit' )->with($notificacion);
   }

   public function edit($codigo){

      $fecha = Fecha::find($codigo);
      $titulo = "Asistencia";

      return view('Asistencia.edit')
         ->with('titulo', $titulo)
         ->with('fecha', $fecha);
   }

   public function update(Request $request, $codigo){



      $fecha = Fecha::find($codigo);
      foreach ($fecha->asistencias as $asistencia) {
         $asistencia->PRESENTE = 0;
         $asistencia->save();
      }

      if (isset($request->codigo)){

         foreach ($request->codigo as $key => $value) {
            $asistencia = Asistencia::find($key);
            $asistencia->PRESENTE = 1;
            $asistencia->save();
         }

         $notificacion = ['message'=>'Asistencia guardada!', 'alert-type' => 'success'];

      }
      return redirect( '/asistencia' )->with($notificacion);
   }


   public function delete($codigo){

      $fecha = Fecha::find($codigo);
      $titulo = "Eliminar Asistencia";

      return view('Asistencia.delete')
         ->with('titulo', $titulo)
         ->with('fecha', $fecha);


   }

   public function destroy($codigo){

   }


}
