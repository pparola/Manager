<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

   protected $table = 'cursos';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'NOMBRE',
   ];

   public function legajos(){
      return $this->hasMany('App\Legajo', 'CURSO', 'CODIGO' );
   }

   public function usuarios(){
      return $this->hasMany('App\User', 'CATEGORIA', 'CODIGO' );
   }


}
