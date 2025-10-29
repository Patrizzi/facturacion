<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenovacionesServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renovaciones_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cotizacion_manual_id')->nullable();
            $table->foreign('cotizacion_manual_id')->references('id')->on('cotizacion_manual')->onDelete('cascade');
            $table->unsignedBigInteger('cotizacion_id')->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizacion')->onDelete('cascade');
            $table->enum('frecuencia', ['Mensual', 'Anual']);
            $table->tinyInteger('dia_mensual')->nullable();
            $table->tinyInteger('mes_anual')->nullable();
            $table->smallInteger('anio_anual')->nullable();
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
        Schema::dropIfExists('renovaciones_servicios');
    }
}
