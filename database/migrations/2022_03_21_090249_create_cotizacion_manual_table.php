<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionManualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_manual', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_cotizacion');
            // ALMACEN
            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');
            // CLIENTE
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            // MONEDA
            $table->unsignedBigInteger('moneda_id');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');
            // FORMA DE PAGO
            $table->unsignedBigInteger('forma_pago_id');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pago')->onDelete('cascade');
            // APROBADO POR
            // $table->unsignedBigInteger('aprobado_por')->nullable();
            // $table->foreign('aprobado_por')->references('id')->on('users')->onDelete('cascade');
            // CAMPOS DE 1 SIN RELACIONES
            $table->string('garantia');
            $table->string('validez');
            $table->string('fecha_emision');
            // $table->string('fecha_vencimiento');
            $table->double('cambio',17,2);
            $table->string('observacion')->nullable();
            // $table->unsignedBigInteger('comisionista_id')->nullable();
            // $table->foreign('comisionista_id')->references('id')->on('personal_ventas')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('estado');
            $table->boolean('estado_vigente');
            //FACTURA O BOLETA
            $table->string('tipo');
            //
            $table->string('op_gravada')->default('0');
            $table->string('op_inafecta')->default('0');
            $table->string('op_exonerada')->default('0');
            $table->string('op_gratuita')->default('0');
            $table->unsignedBigInteger('tipo_operacion_id')->nullable();
            $table->unsignedBigInteger('tipo_documento_id')->nullable();
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
        Schema::dropIfExists('cotizacion_manual');
    }
}
