<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Legajo;
use Maatwebsite\Excel\Facades\Excel;


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
         'NOMBRE'          =>   'required|unique:legajos' ,
         'LEGAJO_ESCOLAR'  =>   'required|unique:legajos',
         'EMAIL'           =>   'required',
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
      $legajo->EMAIL          = mb_strtolower( $request->get('EMAIL'));
      $legajo->CURSO          = Auth::user()->CATEGORIA;
      $legajo->DEREXA         = $request->get('DEREXA');

      $legajo->DNI            = $request->get('DNI');
      $legajo->TELEFONO       = $request->get('TELEFONO');
      $legajo->TELEFONO1      = $request->get('TELEFONO1');


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
         'NOMBRE'          =>   'required' ,
         'LEGAJO_ESCOLAR'  =>   'required',
         'EMAIL'           =>   'required',
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
      $legajo->EMAIL          = strtolower( $request->get('EMAIL'));
      $legajo->CURSO          = Auth::user()->CATEGORIA;
      $legajo->DEREXA         = $request->get('DEREXA');

      $legajo->DNI            = $request->get('DNI');
      $legajo->TELEFONO       = $request->get('TELEFONO');
      $legajo->TELEFONO1      = $request->get('TELEFONO1');

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

   public function reporte(){

      $legajos = Legajo::where('CURSO', Auth::user()->CATEGORIA)
                  ->where('BAJA', null)
                  ->orderBy('LEGAJO_ESCOLAR')
                  ->get();

      $reportes = [];

      foreach ($legajos as $legajo) {

         $reporte = [];
         $reporte['APODO'] = $legajo->LEGAJO_ESCOLAR;
         $reporte['NOMBRE'] = $legajo->NOMBRE;
         $reporte['SALDO'] =  $legajo->saldo;

         if( is_null( $legajo->ultimopago ) ){
            $reporte['UPAGO'] =  '';
         }else{
            $reporte['UPAGO'] =  $legajo->ultimopago->format('d/m/Y');
         }


         $reportes[] = $reporte ;

      }


      Excel::create('Saldos', function($excel) use ($reportes) {

         $encabezado = ['Apodo', 'Nombre', 'Saldo', 'U.Pago'];

         $row = 1;
         $titulo = 'Reporte de Saldos';

         $excel->setTitle($titulo);
         $excel->setCreator('Vicentinos')
          ->setCompany('Vicentinos');
         $excel->setDescription('Reporte generado automaticamente');

         $excel->sheet('Saldos', function($sheet) use($row, $encabezado, $reportes) {

            $sheet->row($row, ['Reporte general de Saldos']);
            $row = $row + 2;

            $sheet->row($row, $encabezado );
            $row = $row + 1;

            $total = 0;

            foreach ($reportes as $reporte) {

               $total = $total + $reporte['SALDO'];

               $body = [];
               $body[] = $reporte['APODO'];
               $body[] = $reporte['NOMBRE'];
               $body[] = number_format( $reporte['SALDO'],2);
               $body[] = $reporte['UPAGO'];

               $sheet->row($row, $body );
               $row = $row + 1;

            }

            $body = [];
            $body[] = 'Total';
            $body[] = '';
            $body[] = number_format( $total,2);
            $body[] = '';

            $sheet->row($row, $body );
            $row = $row + 1;

         });

      })->export('xlsx');

   }

}
