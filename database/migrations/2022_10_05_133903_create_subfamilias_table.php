<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubfamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subfamilias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->unsignedBigInteger('id_familia')->nullable();
            $table->foreign('id_familia')->references('id')->on('familias')->onDelete('cascade'); //familia padre
            $table->string('descripcion'); //nombre descripcion
            $table->string('ubicacion'); //ubicacion
            $table->string('estado'); //estado
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
        // Schema::dropIfExists('subfamilias');
    }
}
