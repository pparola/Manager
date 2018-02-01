<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legajo extends Model
{
   protected $table = 'legajos';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'AINGRESAR',
      'ANO',
      'BAJA',
      'CODIGO',
      'CUOTA_1',
      'CUOTA_2',
      'CUOTA_3',
      'CURSO',  //CATEGORIA
      'DEREXA',
      'DIVISION',
      'ESCUELA', //CLUB
      'LEGAJO_ESCOLAR', //APODO
      'NOMBRE',
      'TURNO',
   ];

   public function club(){
		return $this->belongsTo('App\Club', 'ESCUELA', 'CODIGO');
	}

   public function categoria(){
      return $this->belongsTo('App\Categoria', 'CURSO', 'CODIGO');
   }


}
