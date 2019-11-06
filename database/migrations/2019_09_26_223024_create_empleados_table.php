<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula', 15);
            $table->string('nombre', 50);
            $table->unsignedInteger('institucion_id'); 
            $table->foreign('institucion_id')->references('id')->on('instituciones');
            $table->string('email', 50);            
            $table->string('movil', 15);
            $table->string('telefono', 15)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->float('salario', 8,2)->nullable();
            $table->date('fecing')->nullable();
            $table->date('fecegr')->nullable();
            $table->unsignedInteger('tiponomina_id'); 
            $table->foreign('tiponomina_id')->references('id')->on('tiponominas'); 
            $table->unsignedInteger('cargo_id'); 
            $table->foreign('cargo_id')->references('id')->on('cargos');            
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
        Schema::dropIfExists('empleados');
    }
}
