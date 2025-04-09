<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlarmasRecordatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarmas_recordatorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_comprobante', 255)->nullable(); // FACTURA, BOLETA, NOTA DE CREDITO, NOTA DEBITO
            $table->text('descripcion')->nullable();
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
            $table->unsignedBigInteger('nota_cred_id')->nullable();  // NOTA DE CREDITO
            $table->foreign('nota_cred_id')->references('id')->on('nota_credito')->onDelete('cascade');
            $table->unsignedBigInteger('nota_deb_id')->nullable();  // NOTA DE CREDITO
            $table->foreign('nota_deb_id')->references('id')->on('nota_debito')->onDelete('cascade');
            // FECHAS
            $table->string('dia', 255)->nullable(); // FECHA DE VENCIMIENTO
            $table->string('mes', 255 )->nullable(); // FECHA DE VENCIMIENTO
            $table->string('año'. 255 )->nullable(); // FECHA DE VENCIMIENTO
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
        Schema::dropIfExists('alarmas_recordatorios');
    }
}
