<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCotizacionFacturaRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion_factura_registro', function (Blueprint $table) {
            $table->unsignedBigInteger('servicio_id')->nullable()->after('producto_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->string('descripcion_item')->after('servicio_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacion_factura_registro', function (Blueprint $table) {
            $table->dropColumn('servicio_id');
        });
    }
}
