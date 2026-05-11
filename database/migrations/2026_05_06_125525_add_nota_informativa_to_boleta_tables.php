<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaInformativaToBoletaTables extends Migration
{
    public function up()
    {
        Schema::table('boleta', function (Blueprint $table) {
            $table->text('nota_informativa')->nullable()->after('observacion');
        });

        Schema::table('boleta_m', function (Blueprint $table) {
            $table->text('nota_informativa')->nullable()->after('observacion');
        });
    }

    public function down()
    {
        Schema::table('boleta', function (Blueprint $table) {
            $table->dropColumn('nota_informativa');
        });

        Schema::table('boleta_m', function (Blueprint $table) {
            $table->dropColumn('nota_informativa');
        });
    }
}

