<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarantiasTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('series_productos')) {
            throw new RuntimeException('La tabla series_productos debe existir antes de crear garantias.');
        }

        Schema::create('garantias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('serie_id');
            $table->foreign('serie_id')
                ->references('id')
                ->on('series_productos')
                // RESTRICT conserva el historial auditable mientras exista una serie asociada.
                ->onDelete('restrict');
            $table->string('estado_garantia', 20);
            $table->date('fecha_venta');
            $table->date('fecha_vencimiento');
            $table->unsignedInteger('duracion_meses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('garantias');
    }
}