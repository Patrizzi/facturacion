<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseWarrantyMonthsToKardexEntryRows extends Migration
{
    public function up()
    {
        Schema::table('kardex_entrada_registro', function (Blueprint $table) {
            $table->unsignedInteger('garantia_compra_meses')->nullable()->after('producto_id');
        });
    }

    public function down()
    {
        Schema::table('kardex_entrada_registro', function (Blueprint $table) {
            $table->dropColumn('garantia_compra_meses');
        });
    }
}
