<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
   protected $table = 'asistencias';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'FECHA',   // es una fk no una fecha
      'LEGAJO',
      'PRESENTE',
   ];

   public function fecha(){
      return $this->belongsTo('App\Fecha', 'FECHA', 'CODIGO');
   }

   public function legajo(){
      return $this->belongsTo('App\Legajo', 'LEGAJO', 'CODIGO');
   }


}
