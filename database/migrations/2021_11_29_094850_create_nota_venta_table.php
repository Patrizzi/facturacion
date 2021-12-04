<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_venta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_nota_venta')->nullable();

            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

             $table->unsignedBigInteger('almacen_id')->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');

            $table->string('forma_pago')->nullable();
            $table->string('garantia')->nullable();

            $table->unsignedBigInteger('moneda_id')->nullable();
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');

            $table->string('fecha_emision')->default(date("Y-m-d H:i:s"));
            $table->string('observacion')->nullable();
            $table->string('estado')->default(0);

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
        Schema::dropIfExists('nota_venta');
    }
}
