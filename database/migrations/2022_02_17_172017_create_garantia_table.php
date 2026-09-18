<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarantiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cambios de Longitud en los campos
        Schema::table('cotizacion_factura_registro', function (Blueprint $table) {
            $table->text('descripcion_item')->change();
        });
        Schema::table('boleta_registro', function (Blueprint $table) {
            $table->text('descripcion_item')->change();
        });
        Schema::table('facturacion_registro', function (Blueprint $table) {
            $table->text('descripcion_item')->change();
        });
        Schema::create('garantia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion')->nullable();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('garantia');
    }
}
