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
      'EMAIL',
      'DNI',
      'TELEFONO',
      'TELEFONO1',
   ];

   public function categoria(){
      return $this->belongsTo('App\Categoria', 'CURSO', 'CODIGO');
   }

   public function cuotas(){
      return $this->hasMany('App\Cuota', 'LEGAJO', 'CODIGO');
   }

   public function asistencias(){
      return $this->hasMany('App\Asistencia', 'LEGAJO', 'CODIGO');
   }

   public function getSaldoAttribute(){
      return $this->cuotas->sum('saldocuota');
   }

   public function getUltimopagoAttribute(){
      return $this->cuotas->max('ultimopago');
   }


}
