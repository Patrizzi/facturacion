<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesProductosTable extends Migration
{
    public function up()
    {
        Schema::create('series_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_serie', 50)->unique();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->string('codigo_producto', 50)->index();
            $table->unsignedBigInteger('lote_id')->nullable();
            $table->string('codigo_lote', 50)->nullable();
            $table->string('estado', 30)->default('En Stock');
            $table->date('fecha_venta')->nullable();
            $table->date('fecha_vencimiento_garantia')->nullable();
            $table->string('ubicacion', 100)->nullable();
            $table->char('calidad', 2)->default('A');
            $table->dateTime('fecha_ultimo_movimiento')->nullable();
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });

        if (Schema::hasTable('lotes')) {
            Schema::table('series_productos', function (Blueprint $table) {
                $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('series_productos');
    }
}
