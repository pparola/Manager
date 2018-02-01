<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
   protected $table = 'cuotas';
   public $timestamps = false;
	Protected $primaryKey = 'CODIGO';

   protected $fillable = [
      'ANO',
      'CANCELADO',
      'CODIGO',
      'CONCEPTO',
      'FECHA_1',
      'FPAGADO',
      'IMPORTE',
      'LEGAJO',
      'LIQUIDACION',
      'MES',
      'PAGADO',
   ];}
