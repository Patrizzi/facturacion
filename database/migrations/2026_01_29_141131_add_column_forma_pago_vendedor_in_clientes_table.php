<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFormaPagoVendedorInClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->unsignedBigInteger('vendedor_id')->nullable()->after('fecha_registro');
            $table->foreign('vendedor_id')->references('id')->on('personal_ventas');
            $table->unsignedBigInteger('forma_pago_id')->nullable()->after('vendedor_id');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
}
