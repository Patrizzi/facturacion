<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::table('productos', function (Blueprint $table) {
        $table->text('utilidad', 500)->change();
        $table->string('precio_impuesto')->after('utilidad')->nullable();
        $table->string('precio_venta')->after('utilidad')->nullable();
    });
 }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
   Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('precio_impuesto');
            $table->dropColumn('precio_venta');
        });
    }
}
