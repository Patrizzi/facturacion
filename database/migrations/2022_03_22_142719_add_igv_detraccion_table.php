<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIgvDetraccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('igv', function (Blueprint $table) {
            $table->string('detraccion_porcentaje')->after('renta')->default('6');
            $table->string('cntd_soles_dtrc')->after('renta')->default('700'); //Monto aplicado en Soles
            $table->string('cntd_dolares_dtrc')->after('renta')->default('0'); //Monto aplicado en Soles

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
