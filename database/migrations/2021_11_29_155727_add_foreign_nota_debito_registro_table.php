<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignNotaDebitoRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_debito_registro', function (Blueprint $table) {
            $table->unsignedBigInteger('nota_debito_id')->after('id');
            $table->foreign('nota_debito_id')->references('id')->on('nota_debito')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id')->nullable()->after('nota_debito_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('servicio_id')->nullable()->after('producto_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade')->after('id');
            $table->double('precio',17,2)->after('servicio_id');
            $table->integer('cantidad')->after('precio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_debito', function (Blueprint $table) {
            $table->dropColumn('nota_debito_id');
        });
    }
}
