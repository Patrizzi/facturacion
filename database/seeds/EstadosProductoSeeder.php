<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosProductoSeeder extends Seeder
{
    public function run()
    {
        $estados = [
            ['nombre_estado' => 'En Stock', 'ubicacion' => null, 'calidad' => 'A'],
            ['nombre_estado' => 'Vendido', 'ubicacion' => null, 'calidad' => null],
            ['nombre_estado' => 'En Garantía', 'ubicacion' => null, 'calidad' => null],
        ];

        foreach ($estados as $estado) {
            $query = DB::table('estados_productos');

            foreach ($estado as $column => $value) {
                $value === null
                    ? $query->whereNull($column)
                    : $query->where($column, $value);
            }

            if (!$query->exists()) {
                DB::table('estados_productos')->insert(array_merge($estado, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}