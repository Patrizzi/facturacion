<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaRemisionManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_remision_manual', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_guia');

            $table->unsignedBigInteger('cotizadorm_m_id')->nullable();
            $table->foreign('cotizadorm_m_id')->references('id')->on('cotizacion_manual')->onDelete('cascade');

            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->string('fecha_emision');
            $table->string('fecha_entrega');

            $table->string('vehiculo_publico')->nullable();
            $table->string('conductor_id')->nullable();

            $table->integer('tipo_transporte')->nullable();

            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');

            $table->string('observacion')->nullable();
            $table->string('motivo_traslado')->nullable();

            $table->string('estado_anulado');
            $table->string('estado_registrado');/*cuando la Facturacion ya lo uso- o se vinculó con la fac*/

            $table->boolean('g_electronica')->default(0);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('guia_remision_manuals');
    }
}
