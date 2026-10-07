<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosProductosTable extends Migration
{
    public function up()
    {
        Schema::create('estados_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_estado')->nullable();
            $table->string('ubicacion')->nullable();
            $table->char('calidad', 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estados_productos');
    }
}