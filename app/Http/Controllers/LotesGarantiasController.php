<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Almacen;
use App\Categoria;
use App\Marca;
use App\Provedor;

class LotesGarantiasController extends Controller
{
    /**
     * Muestra el panel de Inventario Inicial / General con métricas y tabla estructurada.
     */
    public function inventarioInicial()
    {
        $almacenes = Almacen::all();
        $categorias = Categoria::all();

        return view('inventario.lotes_garantias.inventario_inicial', compact('almacenes', 'categorias'));
    }

    /**
     * Muestra el panel de Detalle de Lote (Lotes Activos y Vencidos) con filtros.
     */
    public function detalleLote()
    {
        $almacenes = Almacen::all();
        $proveedores = Provedor::all();

        return view('inventario.lotes_garantias.detalle_lote', compact('almacenes', 'proveedores'));
    }

    /**
     * Muestra el panel de Búsqueda por Serie y trazabilidad.
     */
    public function busquedaSerie()
    {
        return view('inventario.lotes_garantias.busqueda_serie');
    }

    /**
     * Muestra el panel de Consulta de Garantía de Producto.
     */
    public function garantiaProducto()
    {
        return view('inventario.lotes_garantias.garantia_producto');
    }

    /**
     * Muestra el panel de Consulta de Garantía de Cliente.
     */
    public function garantiaCliente()
    {
        return view('inventario.lotes_garantias.garantia_cliente');
    }
}
