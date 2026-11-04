<?php

namespace Tests\Feature;

use App\Http\Controllers\LotesGarantias\DetalleLoteController;
use App\Http\Controllers\LotesGarantias\InventarioInicialController;
use App\Lote;
use App\Producto;
use App\Services\LoteSyncService;
use App\Stock_almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LotesGarantiasDetalleLoteTest extends TestCase
{
    /**
     * Prueba que Inventario Inicial retorne productos con existencias y métricas calculadas.
     */
    public function test_inventario_inicial_retorna_productos_y_metricas()
    {
        $controller = app(InventarioInicialController::class);
        $request = new Request();
        $response = $controller->ajaxInventario($request);

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('metricas', $data);
        $this->assertGreaterThan(0, $data['metricas']['unidades_totales']);
        $this->assertNotEmpty($data['productos']);

        // El primer producto es 548 con stock > 0
        $prod548 = collect($data['productos'])->firstWhere('id', 548);
        $this->assertNotNull($prod548);
        $this->assertEquals(7, $prod548['stock']);
    }

    /**
     * Prueba que al abrir Detalle de Lote para un producto con existencias en Inventario Inicial,
     * no aparezca en 0 ni vacío, sino con sus lotes y unidades disponibles correspondientes.
     */
    public function test_detalle_lote_para_producto_con_stock_muestra_lotes_y_metricas()
    {
        $controller = app(DetalleLoteController::class);
        $request = new Request(['id_producto' => 548]);
        $response = $controller->ajaxLotes($request);

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $this->assertEquals(548, $data['producto_info']['id']);
        $this->assertEquals('TP-000023', $data['producto_info']['codigo']);

        // Verificar que las métricas no estén en 0
        $this->assertGreaterThan(0, $data['metricas']['total_lotes']);
        $this->assertEquals(7, $data['metricas']['unidades_disponibles']);
        $this->assertGreaterThan(0, $data['metricas']['conteo_activos']);

        // Verificar que la tabla de lotes no esté vacía
        $this->assertNotEmpty($data['lotes']);
        $this->assertGreaterThanOrEqual(1, count($data['lotes']));

        $loteActivo = $data['lotes'][0];
        $this->assertGreaterThan(0, $loteActivo['cantidad']);
        $this->assertGreaterThan(0, $loteActivo['cantidad_disponible']);
        $this->assertGreaterThan(0, $loteActivo['total_series']);
    }

    /**
     * Prueba que el filtro por almacén funcione correctamente en Detalle de Lote.
     */
    public function test_detalle_lote_filtro_por_almacen()
    {
        $controller = app(DetalleLoteController::class);
        $request = new Request(['id_producto' => 548, 'almacen' => 1]);
        $response = $controller->ajaxLotes($request);

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $alm = \App\Almacen::find(1);
        $this->assertEquals($alm->nombre, $data['producto_info']['almacen']);
        $this->assertEquals(7, $data['metricas']['unidades_disponibles']);
        $this->assertNotEmpty($data['lotes']);
    }

    /**
     * Prueba que ajaxSeriesPorLote devuelva las series individuales del lote.
     */
    public function test_detalle_lote_series_por_lote()
    {
        $lote = Lote::where('producto_id', 548)->first();
        $this->assertNotNull($lote);

        $controller = app(DetalleLoteController::class);
        $request = new Request(['lote_id' => $lote->id]);
        $response = $controller->ajaxSeriesPorLote($request);

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $this->assertEquals($lote->id, $data['lote']['id']);
        $this->assertNotEmpty($data['series']);
        $this->assertEquals($lote->cantidad, count($data['series']));
    }

    /**
     * Prueba que LoteSyncService asegure la existencia de lotes para productos de forma idempotente.
     */
    public function test_lote_sync_service_es_idempotente()
    {
        $lotesAntes = Lote::where('producto_id', 548)->count();
        LoteSyncService::asegurarLotesParaProducto(548);
        $lotesDespues = Lote::where('producto_id', 548)->count();

        $this->assertEquals($lotesAntes, $lotesDespues);
    }

    /**
     * Prueba que TODOS los productos que muestran stock en Inventario Inicial
     * tengan lotes y métricas mayores a 0 en Detalle de Lote.
     */
    public function test_todos_los_productos_con_stock_en_inventario_inicial_tienen_lotes_en_detalle()
    {
        $controllerInv = app(InventarioInicialController::class);
        $controllerDet = app(DetalleLoteController::class);

        // Consultar productos desde Inventario Inicial
        $requestInv = new Request();
        $responseInv = $controllerInv->ajaxInventario($requestInv);
        $dataInv = json_decode($responseInv->getContent(), true);

        $fallas = [];
        foreach ($dataInv['productos'] as $prod) {
            if ($prod['stock'] > 0) {
                $reqDet = new Request(['id_producto' => $prod['id']]);
                $resDet = $controllerDet->ajaxLotes($reqDet);
                $dataDet = json_decode($resDet->getContent(), true);

                if (empty($dataDet['lotes']) || $dataDet['metricas']['unidades_disponibles'] <= 0) {
                    $fallas[] = [
                        'id' => $prod['id'],
                        'codigo' => $prod['codigo'],
                        'nombre' => $prod['producto'],
                        'stock_en_inv' => $prod['stock'],
                        'metricas_detalle' => $dataDet['metricas'] ?? null,
                    ];
                }
            }
        }

        $this->assertEmpty($fallas, 'Productos que en inventario inicial figuran con stock pero en Detalle de Lote salen vacíos o en 0: ' . json_encode($fallas, JSON_PRETTY_PRINT));
    }

    /**
     * Prueba un producto con existencias en múltiples almacenes al cambiar el filtro de almacén.
     */
    public function test_producto_con_stock_en_multiples_almacenes_actualiza_metricas_segun_almacen()
    {
        $producto = Producto::find(548); // TP-000023
        $this->assertNotNull($producto);

        // Simulamos stock en almacén 1 (7 unidades) y creamos stock en almacén 2 (3 unidades)
        DB::beginTransaction();
        try {
            $alm2 = Stock_almacen::firstOrNew(['producto_id' => 548, 'almacen_id' => 2]);
            $alm2->stock = 3;
            $alm2->save();

            $controller = app(DetalleLoteController::class);

            // 1. Consulta sin filtro de almacén (Todos los almacenes) -> debe mostrar 7 + 3 = 10
            $resTodos = $controller->ajaxLotes(new Request(['id_producto' => 548]));
            $dataTodos = json_decode($resTodos->getContent(), true);
            $this->assertTrue($dataTodos['success']);
            $this->assertEquals(10, $dataTodos['metricas']['unidades_disponibles']);

            // 2. Consulta filtrando por Almacén 1 -> debe mostrar 7
            $resAlm1 = $controller->ajaxLotes(new Request(['id_producto' => 548, 'almacen' => 1]));
            $dataAlm1 = json_decode($resAlm1->getContent(), true);
            $this->assertTrue($dataAlm1['success']);
            $this->assertEquals(7, $dataAlm1['metricas']['unidades_disponibles']);

            // 3. Consulta filtrando por Almacén 2 -> debe mostrar 3
            $resAlm2 = $controller->ajaxLotes(new Request(['id_producto' => 548, 'almacen' => 2]));
            $dataAlm2 = json_decode($resAlm2->getContent(), true);
            $this->assertTrue($dataAlm2['success']);
            $this->assertEquals(3, $dataAlm2['metricas']['unidades_disponibles']);

            // 4. Cada lote retornado para Almacén 2 debe tener almacen_id = 2
            foreach ($dataAlm2['lotes'] as $loteItem) {
                $loteDb = Lote::find($loteItem['id']);
                $this->assertEquals(2, $loteDb->almacen_id);
            }
        } finally {
            DB::rollBack();
        }
    }

    /**
     * Prueba que productos con códigos de producto largos no causen desbordamiento en series_productos.
     */
    public function test_generacion_de_series_con_codigo_producto_largo()
    {
        DB::beginTransaction();
        try {
            $prod = Producto::find(548)->replicate();
            $prod->codigo_producto = 'PROD-EXTREMELY-LONG-SKU-CODE-1234567890';
            $prod->codigo_original = 'ORIG-' . uniqid();
            $prod->save();
            Stock_almacen::create([
                'producto_id' => $prod->id,
                'almacen_id' => 1,
                'stock' => 5,
            ]);

            LoteSyncService::asegurarLotesParaProducto($prod, 1);

            $lote = Lote::where('producto_id', $prod->id)->first();
            $this->assertNotNull($lote, 'El lote debe haberse creado a pesar del código largo');
            $this->assertEquals(5, $lote->cantidad);
            $this->assertEquals(5, $lote->cantidad_disponible);

            $series = \App\SerieProducto::where('lote_id', $lote->id)->get();
            $this->assertCount(5, $series);
            foreach ($series as $s) {
                $this->assertLessThanOrEqual(50, strlen($s->numero_serie), 'El número de serie no debe superar 50 caracteres');
            }
        } finally {
            DB::rollBack();
        }
    }

    /**
     * Prueba que al consultar un producto no existente, no se caiga ni muestre silenciosamente otro producto.
     */
    public function test_detalle_lote_con_producto_inexistente()
    {
        $controller = app(DetalleLoteController::class);
        $response = $controller->ajaxLotes(new Request(['id_producto' => 9999999]));

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $this->assertEquals('Producto no encontrado', $data['producto_info']['nombre']);
        $this->assertEquals(0, $data['metricas']['total_lotes']);
        $this->assertEquals(0, $data['metricas']['unidades_disponibles']);
        $this->assertEmpty($data['lotes']);
    }

    /**
     * Prueba que al abrir Detalle de Lote sin especificar producto, se cargue por defecto un producto válido con stock.
     */
    public function test_detalle_lote_sin_parametros_selecciona_primer_producto_con_stock()
    {
        $controller = app(DetalleLoteController::class);
        $response = $controller->ajaxLotes(new Request());

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $this->assertNotNull($data['producto_info']['id']);
        $this->assertNotEquals('--', $data['producto_info']['codigo']);
        $this->assertGreaterThan(0, $data['metricas']['total_lotes']);
        $this->assertGreaterThan(0, $data['metricas']['unidades_disponibles']);
        $this->assertNotEmpty($data['lotes']);
    }

    /**
     * Prueba que cada registro de lote incluya el símbolo de moneda correctamente configurado.
     */
    public function test_detalle_lote_retorna_simbolo_moneda()
    {
        $controller = app(DetalleLoteController::class);
        $response = $controller->ajaxLotes(new Request(['id_producto' => 548]));

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
        $this->assertNotEmpty($data['lotes']);
        $simboloEsperado = DB::table('monedas')->where('principal', 1)->value('simbolo') ?: 'S/';
        foreach ($data['lotes'] as $lote) {
            $this->assertEquals($simboloEsperado, $lote['simbolo_moneda']);
        }
    }
}
