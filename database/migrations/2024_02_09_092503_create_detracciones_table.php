<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetraccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detracciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('factura_id')->references('id')->on('facturacion')->onDelete('cascade');
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->foreign('factura_m_id')->references('id')->on('facturacion_m')->onDelete('cascade');
            $table->unsignedBigInteger('factura_m_id')->nullable();
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_id')->nullable();
            $table->foreign('boleta_m_id')->references('id')->on('boleta_m')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_m_id')->nullable();
            $table->foreign('id_cod_tipo_detraccion')->references('id')->on('tipo_detraccions')->onDelete('cascade');
            $table->unsignedBigInteger('id_cod_tipo_detraccion')->nullable();
            $table->foreign('id_cod_medio_pago')->references('id')->on('medio_pago_detraccions')->onDelete('cascade');
            $table->unsignedBigInteger('id_cod_medio_pago')->nullable();
            $table->string('monto_total_factura');
            $table->string('porcentaje_detraccion');
            $table->string('monto_detraccion');
            $table->boolean('estado');
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
        Schema::dropIfExists('detracciones');
    }
}
