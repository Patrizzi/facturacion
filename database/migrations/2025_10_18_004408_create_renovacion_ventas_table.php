<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenovacionVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renovacion_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cotizacion_id')->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizacion')->onDelete('cascade');
            $table->unsignedBigInteger('cotizacion_manual_id')->nullable();
            $table->foreign('cotizacion_manual_id')->references('id')->on('cotizacion_manual')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('renovacion_ventas');
    }
}