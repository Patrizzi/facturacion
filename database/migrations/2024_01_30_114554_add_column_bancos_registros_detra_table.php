<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBancosRegistrosDetraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banco', function (Blueprint $table) {
            //DESACTIVO = 0  || ACTIVO = 1
            $table->renameColumn('tipo_cuenta', 'nombre_banco');
            $table->renameColumn('numero_soles', 'titular');
            $table->dropColumn('numero_dolares',);
            // $table->boolean('estado_detraccion')->default('0')->after('descripcion2');
        });
        Schema::table('banco_registros', function (Blueprint $table) {
            //DESACTIVO = 0  || ACTIVO = 1
            
            $table->unsignedBigInteger('moneda_id')->nullable()->after('descripcion2');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');
            $table->boolean('estado_detraccion')->default('0')->after('moneda_id');
            $table->renameColumn('descripcion1', 'tipo_cuenta');
            $table->renameColumn('descripcion2', 'nombre_cuenta');
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
