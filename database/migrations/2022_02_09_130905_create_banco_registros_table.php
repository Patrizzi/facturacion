<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banco_registros', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('banco_id')->nullable();
            $table->foreign('banco_id')->references('id')->on('banco')->onDelete('cascade');

            $table->string('descripcion1')->nullable();
            $table->string('descripcion2')->nullable();


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
        Schema::dropIfExists('add_registros_banco');
    }
}
