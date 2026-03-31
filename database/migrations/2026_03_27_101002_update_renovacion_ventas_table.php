<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRenovacionVentasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('renovacion_ventas', function (Blueprint $table) {
            // Eliminar foreign keys primero, luego las columnas
            $table->dropForeign(['nota_venta_id']);
            $table->dropColumn(['nota_venta_id', 'frecuencia', 'dia_mensual', 'dia_anual', 'mes_anual', 'anio_anual']);

            // Agregar nuevos campos (después de cotizacion_manual_id)
            $table->date('fecha_inicio')->after('cotizacion_manual_id');
            $table->date('fecha_vencimiento')->after('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('renovacion_ventas', function (Blueprint $table) {
            // Revertir: quitar los nuevos campos
            $table->dropColumn(['fecha_inicio', 'fecha_vencimiento']);

            // Restaurar los campos eliminados
            $table->unsignedBigInteger('nota_venta_id')->nullable()->after('cotizacion_manual_id');
            $table->foreign('nota_venta_id')->references('id')->on('nota_venta')->onDelete('cascade');
            $table->enum('frecuencia', ['Mensual', 'Anual'])->after('nota_venta_id');
            $table->tinyInteger('dia_mensual')->nullable()->after('frecuencia');
            $table->tinyInteger('dia_anual')->nullable()->after('dia_mensual');
            $table->tinyInteger('mes_anual')->nullable()->after('dia_anual');
            $table->smallInteger('anio_anual')->nullable()->after('mes_anual');
        });
    }
}