<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
   protected $table = 'pagos';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'CONCEPTO',
      'CUOTA',
      'FECHA',
      'IMPORTE',
   ];
}
