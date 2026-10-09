<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServicesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table) {

            $table->unsignedBigInteger('subfamilia_id')->after('familia_id')->nullable();
            $table->foreign('subfamilia_id')->references('id')->on('subfamilias')->onDelete('cascade');

            $table->string('utilidad')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
