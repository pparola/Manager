<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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

      if (is_array($request->codigo)){

         foreach ($request->codigo as $key => $value) {
            $asistencia = Asistencia::find($key);
            $asistencia->PRESENTE = 1;
            $asistencia->save();
         }


      }
      $notificacion = ['message'=>'Asistencia guardada!', 'alert-type' => 'success'];
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

      $fecha = Fecha::find($codigo);
      foreach ($fecha->asistencias as $asistencia) {
         $asistencia->delete();
      }
      $fecha->delete();


      $notificacion = ['message'=>'Asistencia Eliminada!', 'alert-type' => 'success'];
      return redirect( '/asistencia' )->with($notificacion);

   }

   public function addasistencia($codigo){

      $fecha = Fecha::find($codigo);

      $asistencias = [];

      $legajos = Legajo::where('CURSO', Auth::user()->CATEGORIA)
                  ->where('BAJA', null)
                  ->orderBy('LEGAJO_ESCOLAR')
                  ->get();

      foreach ($legajos as $legajo) {

         $asistencia = Asistencia::where('LEGAJO', $legajo->CODIGO)
                        ->where('FECHA', $codigo)
                        ->first();

         if( ! $asistencia ){
            $asistencia = [];
            $asistencia['LEGAJO'] = $legajo->CODIGO;
            $asistencia['LEGAJO_ESCOLAR'] = $legajo->LEGAJO_ESCOLAR;
            $asistencia['NOMBRE'] = $legajo->NOMBRE;
            $asistencias[] = $asistencia;
         }
      }
      //dd($asistencias);

      return view('Asistencia.addasistencia')
         ->with('titulo', 'Agregar Jugador')
         ->with('asistencias', $asistencias )
         ->with('fecha', $fecha);
   }


   public function storeasistencia(Request $request,$codigo ){

      $fecha = Fecha::find($codigo);

      if (is_array($request->codigo)){

         foreach ($request->codigo as $key => $value) {

            $legajo = Legajo::find($key);

            $asistencia = new Asistencia;
            $asistencia->CODIGO         = $this->numerar('ASISTENCIAS');
            $asistencia->FECHA          = $fecha->CODIGO;
            $asistencia->LEGAJO         = $legajo->CODIGO;
            $asistencia->PRESENTE       = 0;
            $asistencia->save();

         }
      }

      $fecha = Fecha::find($codigo);
      $titulo = "Asistencia";

      return view('Asistencia.edit')
         ->with('titulo', $titulo)
         ->with('fecha', $fecha);

   }

   public function deleteasistencia($codigo){

      $asistencia = Asistencia::find($codigo);

      $titulo = "Eliminar Asistencia";

      return view('Asistencia.delasistencia')
         ->with('titulo', $titulo)
         ->with('asistencia', $asistencia);


   }

   public function destroyasistencia(Request $request, $codigo){

      $asistencia = Asistencia::find($codigo);

      $codigoFecha = $asistencia->FECHA;

      $asistencia->delete();

      $fecha = Fecha::find($codigoFecha);
      $titulo = "Asistencia";

      return view('Asistencia.edit')
         ->with('titulo', $titulo)
         ->with('fecha', $fecha);

   }


   public function reporte(){


      $legajos = Legajo::where('CURSO', Auth::user()->CATEGORIA)
                  ->where('BAJA', null)
                  ->orderBy('LEGAJO_ESCOLAR')
                  ->get();

      $fechas = Fecha::orderBy('CODIGO')->get();

      $reportes = [];

      foreach ($legajos as $legajo) {

         $reporte = [];
         $reporte['APODO'] = $legajo->LEGAJO_ESCOLAR;
         $reporte['NOMBRE'] = $legajo->NOMBRE;

         foreach ($fechas as $fecha) {

            $reporte[$fecha->FECHA->format('d-m-Y')] = 0;

            $asistencia = Asistencia::where('LEGAJO', $legajo->CODIGO)
                                    ->where('FECHA', $fecha->CODIGO)
                                    ->first();

            if($asistencia){
               $reporte[$fecha->FECHA->format('d-m-Y')] = $asistencia->PRESENTE;
            }
         }
         $reportes[] = $reporte ;

      }


      Excel::create('Asistencia', function($excel) use ($fechas, $reportes) {

         $encabezado = ['APODO', 'NOMBRE'];
         foreach ($fechas as $fecha){
            $encabezado[] = $fecha->FECHA->format('d-m-Y');
         }
         $encabezado[] = 'total';
         $encabezado[] = '%';

         $row = 1;

         $titulo = 'Reporte de Asistencia';

         $excel->setTitle($titulo);
         $excel->setCreator('Vicentinos')
          ->setCompany('Vicentinos');
         $excel->setDescription('Reporte generado automaticamente');

         $excel->sheet('Asistencia', function($sheet) use($row, $encabezado, $reportes, $fechas) {

            $sheet->row($row, ['Reporte general Asistencia']);
            $row = $row + 2;

            $sheet->row($row, $encabezado );
            $row = $row + 1;

            foreach ($reportes as $reporte) {

               $cantidad = 0;
               $presente = 0;

               $body = [];
               $body[] = $reporte['APODO'];
               $body[] = $reporte['NOMBRE'];

               foreach ($fechas as $fecha) {

                  $body[] = $reporte[  $fecha->FECHA->format('d-m-Y')  ];

                  $cantidad = $cantidad + 1;
                  if( $reporte[  $fecha->FECHA->format('d-m-Y') ] ==1 ){
                     $presente = $presente + 1;
                  }
               }

               $body[] = $presente;
               $body[] = number_format($cantidad/$presente * 100, 2);

               $sheet->row($row, $body );
               $row = $row + 1;

            }

         });

      })->export('xlsx');



   }


}
