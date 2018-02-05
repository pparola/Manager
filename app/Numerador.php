<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Numerador extends Model
{

   protected $table = 'abm_autonumero';
   public $timestamps = false;
	Protected $primaryKey = 'TABLA';

   protected $fillable = [
      'NUMERO',
      'TABLA',
   ];

}
