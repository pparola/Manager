<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
   protected $table = 'fechas';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'FECHA',
      'OBSERVA',
      'CATEGORIA',
   ];

   protected $dates = [
      'FECHA',
   ];

   public function asistencias(){
      return $this->hasMany('App\Asistencia', 'FECHA', 'CODIGO');
   }

   public function getPresentesAttribute(){
      $presentes = 0;
      foreach ($this->asistencias as $asistencia) {
         if($asistencia->PRESENTE==1){
            $presentes = $presentes + 1;
         }
      }
      return $presentes;
   }

   public function getAusentesAttribute(){
      $ausentes = 0;
      foreach ($this->asistencias as $asistencia) {
         if($asistencia->PRESENTE==0){
            $ausentes = $ausentes + 1;
         }
      }
      return $ausentes;
   }

   public function getTotalesAttribute(){
      return $this->asistencias->count() ;
   }



}
