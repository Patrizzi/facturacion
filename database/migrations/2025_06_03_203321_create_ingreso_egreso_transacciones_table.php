<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoEgresoTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_egreso_transacciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaccion_id');
            $table->foreign('transaccion_id')->references('id')->on('transacciones');
            $table->decimal('monto', 8, 2);
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->date('fecha');
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
        Schema::dropIfExists('ingreso_egreso_transacciones');
    }
}