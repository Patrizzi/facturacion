<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeObservacionToTextInComprobantesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE boleta MODIFY observacion TEXT');
        DB::statement('ALTER TABLE boleta_m MODIFY observacion TEXT');
        DB::statement('ALTER TABLE facturacion MODIFY observacion TEXT');
        DB::statement('ALTER TABLE facturacion_m MODIFY observacion TEXT');
        DB::statement('ALTER TABLE guia_remision MODIFY observacion TEXT');
        DB::statement('ALTER TABLE guia_remision_manual MODIFY observacion TEXT');
    }

    /**
     * Reverse the migrations.
     facturacion
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE boleta MODIFY observacion VARCHAR(255)');
        DB::statement('ALTER TABLE boleta_m MODIFY observacion VARCHAR(255)');
        DB::statement('ALTER TABLE facturacion MODIFY observacion VARCHAR(255)');
        DB::statement('ALTER TABLE facturacion_m MODIFY observacion VARCHAR(255)');
        DB::statement('ALTER TABLE guia_remision MODIFY observacion VARCHAR(255)');
        DB::statement('ALTER TABLE guia_remision_manual MODIFY observacion VARCHAR(255)');
    }
}
