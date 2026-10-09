<?php

namespace App\Imports;

use App\Producto;
use App\Marca;
use App\Categoria;
use App\Familia;
use App\Subfamilia;
use App\Unidad_medida;
use App\Estado;
use App\Tipo_afectacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Convertir nombres a IDs usando las relaciones definidas
        $tipo_afectacion_id = Tipo_afectacion::where('nombre', $row['tipo_afectacion'] ?? '')->value('id') ?? 1;
        $categoria_id = Categoria::where('nombre', $row['categoria'] ?? '')->value('id') ?? 1;
        $familia_id = Familia::where('nombre', $row['familia'] ?? '')->value('id') ?? 1;
        $subfamilia_id = Subfamilia::where('nombre', $row['subfamilia'] ?? '')->value('id') ?? 1;
        $marca_id = Marca::where('nombre', $row['marca'] ?? '')->value('id') ?? 1;
        $unidad_medida_id = Unidad_medida::where('nombre', $row['unidad_medida'] ?? '')->value('id') ?? 1;
        $estado_id = Estado::where('nombre', $row['estado'] ?? '')->value('id') ?? 1;

        // Crear o actualizar el producto
        return Producto::updateOrCreate(
            [
                'codigo_producto' => $row['codigo_producto'] ?? '',
                'codigo_original' => $row['codigo_original'] ?? '',
                'nombre' => $row['nombre'] ?? '',
            ],
            [
                'utilidad' => $row['utilidad'] ?? 0,
                'precio_venta' => $row['precio_venta'] ?? 0,
                'precio_impuesto' => $row['precio_impuesto'] ?? 0,
                'descuento1' => $row['descuento1'] ?? 0,
                'descuento2' => $row['descuento2'] ?? 0,
                'descuento_maximo' => $row['descuento_maximo'] ?? 0,
                'descripcion' => $row['descripcion'] ?? '',
                'detalle' => $row['detalle'] ?? '',
                'origen' => $row['origen'] ?? 'Desconocido',
                'garantia' => $row['garantia'] ?? 'Sin garantía',
                'peso' => $row['peso'] ?? '0 kg',
                'stock_minimo' => $row['stock_minimo'] ?? 0,
                'stock_maximo' => $row['stock_maximo'] ?? 0,
                'estado_anular' => $row['estado_anular'] ?? 1,
                'tipo_afectacion_id' => $tipo_afectacion_id,
                'categoria_id' => $categoria_id,
                'familia_id' => $familia_id,
                'subfamilia_id' => $subfamilia_id,
                'marca_id' => $marca_id,
                'unidad_medida_id' => $unidad_medida_id,
                'estado_id' => $estado_id,
            ]
        );
    }
}
