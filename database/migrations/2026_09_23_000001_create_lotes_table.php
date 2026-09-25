<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lote', 50)->index();
            $table->unsignedBigInteger('producto_id')->index();
            $table->string('codigo_producto', 50)->index();
            $table->unsignedBigInteger('almacen_id')->nullable()->index();
            $table->unsignedBigInteger('proveedor_id')->nullable()->index();
            $table->string('proveedor_nombre', 150)->nullable();
            $table->integer('cantidad')->default(0);
            $table->integer('cantidad_disponible')->default(0)->index();
            $table->decimal('costo_individual', 12, 4)->default(0);
            $table->date('fecha_produccion')->nullable();
            $table->date('fecha_vencimiento')->nullable()->index();
            $table->string('estado', 30)->default('Completo')->index();
            $table->unsignedBigInteger('kardex_entrada_registro_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('set null');
            $table->foreign('proveedor_id')->references('id')->on('provedores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotes');
    }
}
