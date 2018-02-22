<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLegajosTable extends Migration
{
   public function up()
   {
      Schema::table('legajos', function (Blueprint $table) {
         $table->integer('DNI');
         $table->string('TELEFONO');
         $table->string('TELEFONO1');
      });        
   }

   public function down()
   {
      Schema::table('legajos', function (Blueprint $table) {
         $table->dropColum('DNI');
         $table->dropColum('TELEFONO');
         $table->dropColum('TELEFONO1');
      });
   }
}
