<?php

namespace App\Http\Controllers\LotesGarantias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Producto;
use App\Stock_producto;
use App\Stock_almacen;
use App\Almacen;
use App\Categoria;
use App\kardex_entrada_registro;

class InventarioInicialController extends Controller
{
    /**
     * Procesa la consulta AJAX para el catálogo de Inventario Inicial y métricas.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxInventario(Request $request)
    {
        $almacenId = $request->filled('almacen') ? (int) $request->almacen : 0;
        $categoriaId = $request->filled('categoria') ? (int) $request->categoria : 0;
        $buscar = trim($request->get('buscar', ''));

        // 1. Consulta base de productos activos
        $query = Producto::with(['categoria_i_producto', 'stock_producto', 'stock_almacen'])
            ->where('estado_anular', 1);

        // Filtro por texto de búsqueda (código o nombre)
        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo_producto', 'LIKE', "%{$buscar}%")
                  ->orWhere('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        // Filtro por Categoría
        if ($categoriaId > 0) {
            $query->where('categoria_id', $categoriaId);
        }

        // Filtro por Almacén si se especifica
        if ($almacenId > 0) {
            $query->whereHas('stock_almacen', function ($q) use ($almacenId) {
                $q->where('almacen_id', $almacenId);
            });
        }

        // Paginación (15 registros por página)
        $perPage = 15;
        $productosPaginados = $query->orderBy('nombre', 'asc')->paginate($perPage);

        // 2. Cálculo de Métricas Globales
        $totalProductosDiferentes = Producto::where('estado_anular', 1)->count();

        // Unidades totales según almacén o general
        if ($almacenId > 0) {
            $unidadesTotales = (int) Stock_almacen::where('almacen_id', $almacenId)->sum('stock');
        } else {
            $unidadesTotales = (int) Stock_producto::sum('stock');
        }

        // Cálculo de valorización total y productos con stock bajo
        $stockBajoCount = 0;
        $valorTotalInventario = 0;

        $todosLosProductos = Producto::with(['stock_producto', 'stock_almacen'])
            ->where('estado_anular', 1)
            ->get();

        foreach ($todosLosProductos as $p) {
            if ($almacenId > 0) {
                $stockActual = (int) optional($p->stock_almacen->firstWhere('almacen_id', $almacenId))->stock ?? 0;
            } else {
                $stockActual = (int) optional($p->stock_producto)->stock ?? 0;
            }

            $stockMinimo = (int) ($p->stock_minimo ?? 0);
            if ($stockActual <= $stockMinimo) {
                $stockBajoCount++;
            }

            // Estimación de costo base
            $costoBase = (float) (optional($p->stock_producto)->precio_nacional ?? 0);
            $valorTotalInventario += ($stockActual * $costoBase);
        }

        // Nombre de almacén para mostrar
        $almacenNombre = 'Almacén Principal';
        if ($almacenId > 0) {
            $almObj = Almacen::find($almacenId);
            if ($almObj) {
                $almacenNombre = $almObj->nombre;
            }
        }

        // 3. Formateo de Productos para la Tabla
        $items = [];
        foreach ($productosPaginados as $prod) {
            if ($almacenId > 0) {
                $stock = (int) optional($prod->stock_almacen->firstWhere('almacen_id', $almacenId))->stock ?? 0;
            } else {
                $stock = (int) optional($prod->stock_producto)->stock ?? 0;
            }

            $costo = (float) (optional($prod->stock_producto)->precio_nacional ?? 0);
            $costoPromedio = $costo > 0 ? $costo : 0;
            $precioVenta = (float) ($prod->precio_venta ?? 0);

            // Precio sugerido proyectado con margen si no está configurado
            $precioSugerido = $precioVenta > 0 ? round($precioVenta * 1.15, 2) : round($costoPromedio * 1.30, 2);

            $valorTotal = $stock * $costoPromedio;

            $items[] = [
                'codigo' => $prod->codigo_producto ?? '--',
                'producto' => $prod->nombre ?? '--',
                'categoria' => optional($prod->categoria_i_producto)->nombre ?? 'General',
                'stock' => $stock,
                'costo' => number_format($costo, 2),
                'costo_promedio' => number_format($costoPromedio, 2),
                'precio_venta' => number_format($precioVenta, 2),
                'precio_sugerido' => number_format($precioSugerido, 2),
                'almacen' => $almacenNombre,
                'valor_total' => number_format($valorTotal, 2)
            ];
        }

        return response()->json([
            'success' => true,
            'metricas' => [
                'productos_diferentes' => $totalProductosDiferentes,
                'unidades_totales' => $unidadesTotales,
                'valor_total_inventario' => '$ ' . number_format($valorTotalInventario, 2),
                'stock_bajo' => $stockBajoCount
            ],
            'productos' => $items,
            'paginacion' => [
                'total' => $productosPaginados->total(),
                'per_page' => $productosPaginados->perPage(),
                'current_page' => $productosPaginados->currentPage(),
                'last_page' => $productosPaginados->lastPage()
            ]
        ]);
    }
}
