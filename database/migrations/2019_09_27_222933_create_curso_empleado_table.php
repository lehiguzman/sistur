<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_empleado', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empleado_id'); 
            $table->foreign('empleado_id')->references('id')->on('empleados');       
            $table->unsignedInteger('curso_id'); 
            $table->foreign('curso_id')->references('id')->on('cursos');  
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
        Schema::dropIfExists('curso_empleado');
    }
}
