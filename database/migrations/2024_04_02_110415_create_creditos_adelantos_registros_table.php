<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditosAdelantosRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos_adelantos_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creditos_adl_id')->nullable();  // FACTURA
            $table->foreign('creditos_adl_id')->references('id')->on('creditos_adelantos')->onDelete('cascade');
            $table->unsignedBigInteger('cuota_cred_id')->nullable();  // CUOTA
            $table->foreign('cuota_cred_id')->references('id')->on('cuotas_creditos')->onDelete('cascade');
            $table->string('tipo_pago'); // EFECTIVO - TARJETA - ETC
            $table->string('numero_input')->nullable();
            $table->string('fechas_input')->nullable();
            $table->double('montos_input',17,2)->nullable(); // sumatoria para la cabecera
            $table->string('bancos_input')->nullable();
            $table->string('persona_input')->nullable();
            $table->string('adicional_input')->nullable();
            $table->text('file_input')->nullable();
            $table->text('notas_adicionales')->nullable();
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
        Schema::dropIfExists('creditos_adelantos_registros');
    }
}
