<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Numerador;

class Controller extends BaseController
{
   use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public function numerar($tabla){
      $numerador = Numerador::find($tabla);
      if(!$numerador){
         $numerador = new Numerador;
         $numerador->TABLA = $tabla;
         $numerador->NUMERO = 0;
      }
      $numerador->NUMERO = $numerador->NUMERO + 1;
      $numerador->save();
      return $numerador->NUMERO;
   }

}
