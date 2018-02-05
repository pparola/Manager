<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Legajo;

class LegajoController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }

   public function index()
   {
      $titulo = "Legajos";
      $legajos = Legajo::where('CURSO', Auth::user()->CATEGORIA)
                  ->where('BAJA', null)
                  ->orderBy('LEGAJO_ESCOLAR')
                  ->get();

      return view('Legajo.Index')
         ->with('legajos', $legajos)
         ->with('titulo', $titulo);

   }

   public function create()
   {
      return view('Legajo.create')
         ->with('titulo', 'Agregar Legajo');

   }

   public function store(Request $request)
   {
      $rules = [
         'NOMBRE'         =>   'required' ,
         'LEGAJO_ESCOLAR' =>   'required',
      ];
      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {
         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput();
      }

      $legajo = new Legajo;
      $legajo->CODIGO         = $this->numerar('LEGAJOS');
      $legajo->NOMBRE         = strtoupper( $request->get('NOMBRE'));
      $legajo->LEGAJO_ESCOLAR = strtoupper( $request->get('LEGAJO_ESCOLAR'));
      $legajo->CURSO          = Auth::user()->CATEGORIA;
      $legajo->save();

      $notificacion = ['message'=>'Registro Agregado!', 'alert-type' => 'success'];

      return redirect( '/legajo' )->with($notificacion);
   }


   public function edit($codigo)
   {
      $legajo = Legajo::find($codigo);

      return view('Legajo.update')
         ->with('legajo', $legajo)
         ->with('titulo', 'Actualizar Legajo');
   }

   public function update(Request $request, $codigo)
   {
      $rules = [
         'NOMBRE'         =>   'required' ,
         'LEGAJO_ESCOLAR' =>   'required',
      ];
      $valido = Validator::make($request->all(), $rules);

      if ($valido->fails()) {

         $notificacion = ['message'=>'Error en Ingreso', 'alert-type' => 'error'];

         return redirect()
            ->back()
            ->withErrors($valido)
            ->withInput()
            ->with($notificacion);
      }

      $legajo = Legajo::find($codigo);
      $legajo->NOMBRE         = strtoupper( $request->get('NOMBRE'));
      $legajo->LEGAJO_ESCOLAR = strtoupper( $request->get('LEGAJO_ESCOLAR'));
      $legajo->CURSO          = Auth::user()->CATEGORIA;
      if( $request->get('BAJA')){
         $legajo->Baja = $request->get('BAJA'); 
      }
      $legajo->save();

      $notificacion = ['message'=>'Registro Actualizado!', 'alert-type' => 'success'];

      return redirect( '/legajo' )->with($notificacion);

   }

   public function delete($codigo)
   {
      $legajo = Legajo::find($codigo);

      return view('Legajo.delete')
         ->with('legajo', $legajo)
         ->with('titulo', 'Eliminar Legajo');
   }

   public function destroy($codigo)
   {
      $legajo = Legajo::find($codigo);
      if($legajo){
         $notificacion = ['message'=>'Registro Eliminado!', 'alert-type' => 'success'];
         $legajo->delete();
      }else{
         $notificacion = ['message'=>'No existe Registro', 'alert-type' => 'error'];
      }
      return redirect( '/legajo' )->with($notificacion);
   }
}
