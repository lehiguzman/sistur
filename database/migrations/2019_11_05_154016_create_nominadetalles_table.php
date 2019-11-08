<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominadetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominadetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empleado_id'); 
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->float('monsal', 8, 2)->nullable();
            $table->float('monded', 8, 2)->nullable();
            $table->unsignedInteger('nomina_id'); 
            $table->foreign('nomina_id')->references('id')->on('nominas')->onDelete('cascade');
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
        Schema::dropIfExists('nominadetalles');
    }
}
