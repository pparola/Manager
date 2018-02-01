<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
   protected $table = 'liquidaciones';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'CONCEPTO',
      'ESCUELA', //CLUB
      'SUMA_FIJA', 
      'VENCIMIENTO_1',
   ];
}
