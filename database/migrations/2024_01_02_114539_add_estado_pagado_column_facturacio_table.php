<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoPagadoColumnFacturacioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturacion', function (Blueprint $table){
            // 0 sin pagar ||| 1 pagado parcial(creditos) ||||||||| 2 pagado total
            $table->boolean('estado_pago')->default('0')->after('f_electronica'); // 0 es no pagado
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
