<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('telefono', 15);
            $table->string('direccion', 100)->nullable();            
            $table->unsignedInteger('tipo_id'); 
            $table->foreign('tipo_id')->references('id')->on('tipos');          
            $table->unsignedInteger('rama_id'); 
            $table->foreign('rama_id')->references('id')->on('ramas');          
            $table->unsignedInteger('estado_id'); 
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instituciones');
    }
}
