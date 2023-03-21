<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacacionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacacion_forms', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->date('fecha_ret');
            $table->integer('dias_v');
            $table->string('dias_v_l');
            $table->integer('dias');
            $table->string('dias_l');
            $table->integer('saldo_dias');
            $table->string('saldo_dias_l');
            $table->timestamps();   

            $table->integer('user_id');
            //AUTORIZACION
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacacion_forms');
    }
}
