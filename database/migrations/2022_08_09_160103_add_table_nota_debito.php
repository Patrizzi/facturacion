<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableNotaDebito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_debito', function (Blueprint $table) {
            $table->unsignedBigInteger('facturacion_m_id')->nullable()->after('boleta_id');
            $table->foreign('facturacion_m_id')->references('id')->on('facturacion_m')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_m_id')->nullable()->after('facturacion_m_id');
            $table->foreign('boleta_m_id')->references('id')->on('boleta_m')->onDelete('cascade');
            $table->string('fecha_emision')->nullable()->after('boleta_m_id');
            $table->integer('estado')->after('fecha_emision')->default(0);
            $table->integer('n_electronica')->after('estado')->default(0);
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
