<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNotasRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_credito_registro', function (Blueprint $table) {
            $table->decimal('precio', 17, 8)->change();
        });
        Schema::table('nota_debito_registro', function (Blueprint $table) {
            $table->decimal('precio', 17, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_credito_registro', function (Blueprint $table) {
            $table->decimal('precio', 17, 2)->change();
        });
         Schema::table('nota_debito_registro', function (Blueprint $table) {
            $table->decimal('precio', 17, 2)->change();
        });
    }
}
