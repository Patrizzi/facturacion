<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RefactorEstadosInSeriesProductosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('series_productos')) {
            throw new RuntimeException('La tabla series_productos debe existir antes de ejecutar esta migración.');
        }

        Schema::table('series_productos', function (Blueprint $table) {
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados_productos');
        });

        $combinaciones = DB::table('series_productos')
            ->select('estado', 'ubicacion', 'calidad')
            ->distinct()
            ->get();

        foreach ($combinaciones as $combinacion) {
            $valores = [
                'estado' => $combinacion->estado,
                'ubicacion' => $combinacion->ubicacion,
                'calidad' => $combinacion->calidad,
            ];

            $catalogoQuery = DB::table('estados_productos');
            foreach ($valores as $column => $value) {
                $catalogoQuery = $value === null
                    ? $catalogoQuery->whereNull($column === 'estado' ? 'nombre_estado' : $column)
                    : $catalogoQuery->where($column === 'estado' ? 'nombre_estado' : $column, $value);
            }

            $estadoProducto = $catalogoQuery->first();
            if (!$estadoProducto) {
                $estadoId = DB::table('estados_productos')->insertGetId([
                    'nombre_estado' => $valores['estado'],
                    'ubicacion' => $valores['ubicacion'],
                    'calidad' => $valores['calidad'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $estadoId = $estadoProducto->id;
            }

            $seriesQuery = DB::table('series_productos');
            foreach ($valores as $column => $value) {
                $seriesQuery = $value === null
                    ? $seriesQuery->whereNull($column)
                    : $seriesQuery->where($column, $value);
            }
            $seriesQuery->update(['estado_id' => $estadoId]);
        }

        Schema::table('series_productos', function (Blueprint $table) {
            $table->dropColumn(['estado', 'ubicacion', 'calidad']);
        });
    }

    public function down()
    {
        Schema::table('series_productos', function (Blueprint $table) {
            $table->string('estado')->nullable();
            $table->string('ubicacion')->nullable();
            $table->char('calidad', 2)->nullable();
        });

        DB::table('series_productos')
            ->join('estados_productos', 'series_productos.estado_id', '=', 'estados_productos.id')
            ->select('series_productos.id', 'estados_productos.nombre_estado', 'estados_productos.ubicacion', 'estados_productos.calidad')
            ->orderBy('series_productos.id')
            ->chunk(500, function ($series) {
                foreach ($series as $serie) {
                    DB::table('series_productos')
                        ->where('id', $serie->id)
                        ->update([
                            'estado' => $serie->nombre_estado,
                            'ubicacion' => $serie->ubicacion,
                            'calidad' => $serie->calidad,
                        ]);
                }
            });

        Schema::table('series_productos', function (Blueprint $table) {
            $table->dropForeign(['estado_id']);
            $table->dropColumn('estado_id');
        });
    }
}