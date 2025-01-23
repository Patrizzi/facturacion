<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_managers', function (Blueprint $table) {
            $table->id();
            $table->string('ruc');
            $table->string('nombre');
            $table->string('centro_costo');
            $table->foreignId('administrador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cliente_id');
            $table->foreignId('project_service_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_cierre');
            $table->integer('prioridad')->default(1);
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
        Schema::dropIfExists('project_managers');
    }
}
