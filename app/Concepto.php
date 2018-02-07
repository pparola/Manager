<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
   protected $table = 'conceptos';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'NOMBRE',
   ];

   public function liquidaciones(){
      return $this->hasMany('App\Liquidacion', 'CONCEPTO', 'CODIGO');
   }


}
