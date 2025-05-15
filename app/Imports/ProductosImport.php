<?php
namespace App\Imports;

use App\Producto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Verificar si el producto ya existe
        $producto = Producto::where('codigo_producto', $row['codigo_producto'])
                            ->where('codigo_original', $row['codigo_original'])
                            ->where('nombre', $row['nombre'])
                            ->first();

        // Si el producto existe, actualizarlo
        if ($producto) {
            $producto->update([
                'utilidad' => $row['utilidad'],
                'precio_venta' => $row['precio_venta'],
                'precio_impuesto' => $row['precio_impuesto'],
                'descuento1' => $row['descuento1'],
                'descuento2' => $row['descuento2'],
                'descuento_maximo' => $row['descuento_maximo'],
                'descripcion' => $row['descripcion'],
                'detalle' => $row['detalle'],
                'origen' => $row['origen'],
                'garantia' => $row['garantia'],
                'peso' => $row['peso'],
                'stock_minimo' => $row['stock_minimo'],
                'stock_maximo' => $row['stock_maximo'],
                'foto' => $row['foto'],
                'archivo' => $row['archivo'],
                'estado_anular' => $row['estado_anular'],
                'tipo_afectacion_id' => $row['tipo_afectacion_id'],
                'categoria_id' => $row['categoria_id'],
                'familia_id' => $row['familia_id'],
                'subfamilia_id' => $row['subfamilia_id'],
                'marca_id' => $row['marca_id'],
                'unidad_medida_id' => $row['unidad_medida_id'],
                'estado_id' => $row['estado_id'],
            ]);
        }
        // Si no existe, crearlo
        else {
            $producto = new Producto([
                'codigo_producto' => $row['codigo_producto'],
                'codigo_original' => $row['codigo_original'],
                'nombre' => $row['nombre'],
                'utilidad' => $row['utilidad'],
                'precio_venta' => $row['precio_venta'],
                'precio_impuesto' => $row['precio_impuesto'],
                'descuento1' => $row['descuento1'],
                'descuento2' => $row['descuento2'],
                'descuento_maximo' => $row['descuento_maximo'],
                'descripcion' => $row['descripcion'],
                'detalle' => $row['detalle'],
                'origen' => $row['origen'],
                'garantia' => $row['garantia'],
                'peso' => $row['peso'],
                'stock_minimo' => $row['stock_minimo'],
                'stock_maximo' => $row['stock_maximo'],
                'foto' => $row['foto'],
                'archivo' => $row['archivo'],
                'estado_anular' => $row['estado_anular'],
                'tipo_afectacion_id' => $row['tipo_afectacion_id'],
                'categoria_id' => $row['categoria_id'],
                'familia_id' => $row['familia_id'],
                'subfamilia_id' => $row['subfamilia_id'],
                'marca_id' => $row['marca_id'],
                'unidad_medida_id' => $row['unidad_medida_id'],
                'estado_id' => $row['estado_id'],
            ]);

            $producto->save();
        }

        return $producto;
    }
}

