<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaCreditoColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_credito', function (Blueprint $table) {
            $table->unsignedBigInteger('boleta_m_id')->after('facturacion_m_id')->nullable();
            $table->foreign('boleta_m_id')->references('id')->on('boleta_m')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
