<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReclamosGarantiaTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('series_productos') || !Schema::hasTable('clientes')) {
            throw new RuntimeException('Deben existir series_productos y clientes antes de crear reclamos_garantia.');
        }

        Schema::create('reclamos_garantia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('serie_id');
            $table->foreign('serie_id')->references('id')->on('series_productos')
                // Restringir evita borrar series con un reclamo que forma parte de su historial.
                ->restrictOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes')
                // Restringir conserva la identidad del cliente asociada al reclamo.
                ->restrictOnDelete();
            $table->text('descripcion_falla');
            $table->string('estado', 30)->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reclamos_garantia');
    }
}