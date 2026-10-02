<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosEvidenciaGarantiaTable extends Migration
{
    public function up()
    {
        Schema::create('archivos_evidencia_garantia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('reclamo_garantia_id')->constrained('reclamos_garantia')
                // Los metadatos no deben quedar huérfanos si se elimina su reclamo.
                ->cascadeOnDelete();
            $table->string('ruta_archivo');
            $table->string('tipo_archivo', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archivos_evidencia_garantia');
    }
}