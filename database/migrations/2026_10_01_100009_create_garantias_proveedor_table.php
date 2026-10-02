<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarantiasProveedorTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('provedores')) {
            throw new RuntimeException('La tabla provedores debe existir antes de crear garantias_proveedor.');
        }

        Schema::create('garantias_proveedor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('reclamo_garantia_id')->unique()->constrained('reclamos_garantia')
                // El proceso back-to-back pertenece al reclamo y se elimina con este.
                ->cascadeOnDelete();
            $table->foreignId('proveedor_id')->constrained('provedores')
                // Restringir mantiene íntegra la referencia histórica al proveedor.
                ->restrictOnDelete();
            $table->string('estado_solicitud', 20)->default('Enviado');
            $table->text('resolucion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('garantias_proveedor');
    }
}