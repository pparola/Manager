<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
   ];

   protected $dates = [
      'FECHA_1',
      'ultimopago',
   ];

   public function liquidacion(){
      return $this->belongsTo('App\Liquidacion', 'LIQUIDACION', 'CODIGO');
   }

   public function legajo(){
      return $this->belongsTo('App\Legajo', 'LEGAJO', 'CODIGO');
   }

   public function pagos(){
      return $this->hasMany('App\Pago', 'CUOTA', 'CODIGO');
   }

   public function getImportepagadoAttribute(){
      $suma = 0;
      foreach ($this->pagos as $pago) {
         $suma = $suma + $pago->IMPORTE;
      }
      return $suma;
   }

   public function getSaldocuotaAttribute(){
      $suma = $this->IMPORTE_1;
      foreach ($this->pagos as $pago) {
         $suma = $suma - $pago->IMPORTE;
      }
      return $suma;
   }

   public function getUltimopagoAttribute(){
      return $this->pagos->max('FECHA');
   }


}
