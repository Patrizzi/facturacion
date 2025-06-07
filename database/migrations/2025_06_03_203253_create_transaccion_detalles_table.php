<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccion_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('metodo_pago');
            $table->unsignedBigInteger('transaccion_id')->nullable();
            $table->foreign('transaccion_id')->references('id')->on('transacciones');
            $table->string('nro_operacion')->nullable();
            $table->string('comprobante')->nullable();
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
        Schema::dropIfExists('transaccion_detalles');
    }
}
