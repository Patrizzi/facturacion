<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('project_managers')->onDelete('cascade');
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nombre');
            $table->text('contenido');
            $table->date('fecha_inicio');
            $table->date('fecha_cierre');
            $table->integer('estado')->default(1);
            $table->string('color');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
