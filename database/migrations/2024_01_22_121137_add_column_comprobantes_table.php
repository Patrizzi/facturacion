<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturacion_m', function (Blueprint $table){
            // 0 sin pagar ||| 1 pagado parcial(creditos) ||||||||| 2 pagado total
            $table->boolean('estado_pago')->default('0')->after('f_electronica'); // 0 es no pagado
        });
        Schema::table('boleta', function (Blueprint $table){
            // 0 sin pagar ||| 1 pagado parcial(creditos) ||||||||| 2 pagado total
            $table->boolean('estado_pago')->default('0')->after('b_electronica'); // 0 es no pagado
        });
        Schema::table('boleta_m', function (Blueprint $table){
            // 0 sin pagar ||| 1 pagado parcial(creditos) ||||||||| 2 pagado total
            $table->boolean('estado_pago')->default('0')->after('b_electronica'); // 0 es no pagado
        });
        Schema::table('nota_venta', function (Blueprint $table){
            // 0 sin pagar ||| 1 pagado parcial(creditos) ||||||||| 2 pagado total
            $table->boolean('estado_pago')->default('0')->after('estado_vigente'); // 0 es no pagado
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
