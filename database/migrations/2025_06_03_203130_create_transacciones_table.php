<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->string('nro_pago');
            $table->string('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('monto', 8, 2);
            $table->boolean('estado')->nullable();
            $table->date('fecha');
            $table->unsignedBigInteger('caja_id')->nullable();
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->unsignedBigInteger('personal_id')->nullable();
            $table->foreign('personal_id')->references('id')->on('personal');
            $table->unsignedBigInteger('tipo_transaccion_id')->nullable();
            $table->foreign('tipo_transaccion_id')->references('id')->on('tipo_transacciones');
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
        Schema::dropIfExists('transacciones');
    }
}
