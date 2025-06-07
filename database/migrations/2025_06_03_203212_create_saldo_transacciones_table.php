<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_transacciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('saldo_actual', 8, 2);
            $table->unsignedBigInteger('transaccion_id')->nullable();
            $table->foreign('transaccion_id')->references('id')->on('transacciones');
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
        Schema::dropIfExists('saldo_transacciones');
    }
}
