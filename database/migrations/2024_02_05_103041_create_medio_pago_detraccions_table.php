<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedioPagoDetraccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medio_pago_detraccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->string('descripcion');
            $table->boolean('estado')->default('0');
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
        Schema::dropIfExists('medio_pago_detraccions');
    }
}
