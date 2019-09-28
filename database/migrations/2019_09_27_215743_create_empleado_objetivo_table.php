<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadoObjetivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_objetivo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empleado_id'); 
            $table->foreign('empleado_id')->references('id')->on('empleados');       
            $table->unsignedInteger('objetivo_id'); 
            $table->foreign('objetivo_id')->references('id')->on('objetivos');       
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
        Schema::dropIfExists('empleado_objetivo');
    }
}
