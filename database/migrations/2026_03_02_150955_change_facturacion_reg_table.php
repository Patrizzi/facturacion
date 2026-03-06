<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFacturacionRegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturacion_registro', function (Blueprint $table) {
            $table->decimal('promedio_original', 17, 8)->change();
            $table->decimal('precio', 17, 8)->change();
            $table->decimal('precio_unitario_desc', 17, 8)->change();
            $table->decimal('precio_unitario_comi', 17, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('facturacion_registro', function (Blueprint $table) {
            $table->decimal('promedio_original', 17, 2)->change();
            $table->decimal('precio', 17, 2)->change();
            $table->decimal('precio_unitario_desc', 17, 2)->change();
            $table->decimal('precio_unitario_comi', 17, 2)->change();
        });
    }
}
