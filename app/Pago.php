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
      'USUARIO'
   ];

   protected $dates = [
      'FECHA',
   ];

   public function cuota(){
      return $this->belongsTo('App\Cuota', 'CUOTA', 'CODIGO');
   }

   public function usuario(){
      return $this->belongsTo('App\User', 'USUARIO', 'id');
   }



}
