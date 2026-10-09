<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->renameColumn('fecha_inicio', 'fecha_inicio_old');
            $table->renameColumn('fecha_cierre', 'fecha_cierre_old'); 
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->datetime('fecha_inicio')->nullable()->after('contenido');
            $table->datetime('fecha_cierre')->nullable()->after('contenido');
        });
        DB::table('activities')->update([
            'fecha_inicio' => DB::raw("STR_TO_DATE(fecha_inicio_old, '%Y-%m-%d')"),
            'fecha_cierre' => DB::raw("STR_TO_DATE(fecha_cierre_old, '%Y-%m-%d')")
        ]);
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('fecha_inicio_old');
            $table->dropColumn('fecha_cierre_old');
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
