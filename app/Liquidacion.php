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

   public function categoria(){
      return $this->belongsTo('App\Categoria', 'ESCUELA', 'CODIGO');
   }

   public function concepto(){
      return $this->belongsTo('App\Concepto', 'CONCEPTO', 'CODIGO');
   }

   public function cuotas(){
      return $this->hasMany('App\Cuota', 'LIQUIDACION', 'CODIGO');
   }


}
