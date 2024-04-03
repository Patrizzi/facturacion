<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditosAdelantosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos_adelantos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('factura_id')->nullable();  // FACTURA
            $table->foreign('factura_id')->references('id')->on('facturacion')->onDelete('cascade');
            $table->unsignedBigInteger('factura_m_id')->nullable();  // FACTURA MANUAL
            $table->foreign('factura_m_id')->references('id')->on('facturacion_m')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_id')->nullable();  // BOLETA
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_m_id')->nullable();  // BOLETA MANUAL
            $table->foreign('boleta_m_id')->references('id')->on('boleta_m')->onDelete('cascade');
            $table->unsignedBigInteger('nota_ven_id')->nullable();  // NOTA VENTA
            $table->foreign('nota_ven_id')->references('id')->on('nota_venta')->onDelete('cascade');
            $table->unsignedBigInteger('cuota_cred_id')->nullable();  // CUOTA
            $table->foreign('cuota_cred_id')->references('id')->on('cuotas_creditos')->onDelete('cascade');
            $table->date('fecha_pago');
            $table->string('precio_total_pago');
            $table->string('precio_adelanto');
            $table->string('notas_adicionales', 764)->nullable();
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
        Schema::dropIfExists('creditos_adelantos');
    }
}
