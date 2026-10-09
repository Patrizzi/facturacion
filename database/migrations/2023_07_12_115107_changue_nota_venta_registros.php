<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangueNotaVentaRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_venta_registro', function (Blueprint $table) {
            $table->string('precio_nacional')->nullable()->change();
            // $table->double('precio_nacional',10,2);

            // $table->string('email')->dropUnique()->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
