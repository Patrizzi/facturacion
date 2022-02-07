<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignNotaDebitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_debito', function (Blueprint $table) {
            $table->string('codigo_n_d')->nullable()->after('id');
            $table->unsignedBigInteger('facturacion_id')->nullable()->after('codigo_n_d');
            $table->foreign('facturacion_id')->references('id')->on('facturacion')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_id')->nullable()->after('facturacion_id');
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');
            $table->string('tipo')->nullable()->after('boleta_id');
            $table->unsignedBigInteger('almacen_id')->nullable()->after('tipo');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');
            $table->string('op_gravada')->default('0')->after('almacen_id');
            $table->string('op_inafecta')->default('0')->after('op_gravada');
            $table->string('op_exonerada')->default('0')->after('op_inafecta');
            $table->string('op_gratuita')->default('0')->after('op_exonerada');
            $table->string('motivo')->after('op_gratuita');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_debito', function (Blueprint $table) {
            $table->dropColumn('codigo_n_d');
        });
    }
}
