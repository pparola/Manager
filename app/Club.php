<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
   protected $table = 'escuelas';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'CODIGO',
      'NOMBRE',
   ];

   public function legajos(){
     return $this->hasMany('App\Legajo', 'ESCUELA', 'CODIGO' );
   }

}
