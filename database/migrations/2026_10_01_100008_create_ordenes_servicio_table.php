<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesServicioTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            throw new RuntimeException('La tabla users debe existir antes de crear ordenes_servicio.');
        }

        Schema::create('ordenes_servicio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('reclamo_garantia_id')->unique()->constrained('reclamos_garantia')
                // La orden depende del reclamo; se limpia al eliminarlo.
                ->cascadeOnDelete();
            $table->foreignId('tecnico_id')->nullable()->constrained('users')
                // Se conserva el diagnóstico aunque el usuario técnico sea eliminado.
                ->nullOnDelete();
            $table->text('diagnostico_tecnico')->nullable();
            $table->string('estado', 30)->default('Pendiente');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordenes_servicio');
    }
}