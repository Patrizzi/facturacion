<?php

namespace Tests\Feature;

use App\ArchivoEvidenciaGarantia;
use App\Cliente;
use App\EstadoProducto;
use App\Facturacion;
use App\Facturacion_registro;
use App\GarantiaProveedor;
use App\GarantiaSerie;
use App\Jobs\NotificarProveedorReclamoB2B;
use App\Lote;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\OrdenServicio;
use App\Producto;
use App\Provedor;
use App\ReclamoGarantia;
use App\SerieProducto;
use App\Services\GarantiaRulesEngineService;
use App\ValueObjects\VeredictoGarantia;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CuatroCommitsIntegracionTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Queue::fake();
    }

    private function createTestProduct(string $nombre, ?string $codigo = null): Producto
    {
        $code = $codigo ?? ('TEST-' . uniqid());
        $sample = Producto::first();

        if ($sample) {
            $data = $sample->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);
            $data['nombre'] = $nombre;
            $data['codigo_producto'] = $code;
            $data['codigo_original'] = $code;
            $data['garantia'] = '12 meses';

            return Producto::create($data);
        }

        return Producto::create([
            'nombre'             => $nombre,
            'codigo_producto'    => $code,
            'codigo_original'    => $code,
            'utilidad'           => 10,
            'garantia'           => '12 meses',
            'categoria_id'       => 1,
            'marca_id'           => 1,
            'unidad_medida_id'   => 1,
            'tipo_afectacion_id' => 1,
            'estado_id'          => 1,
        ]);
    }

    /**
     * Test Commit 1 (67ede50): NotaVentaRegistroObserver actualiza stock,
     * marca serie como 'Vendido' y persiste GarantiaSerie en estado 'Vigente'.
     */
    public function test_commit1_nota_venta_registro_observer_persiste_garantia_y_estado_vendido()
    {
        $estadoEnStock = EstadoProducto::firstOrCreate(
            ['nombre_estado' => 'En Stock'],
            ['ubicacion' => 'Almacén Central', 'calidad' => 'A']
        );
        $estadoVendido = EstadoProducto::firstOrCreate(
            ['nombre_estado' => 'Vendido'],
            ['ubicacion' => 'Despachado', 'calidad' => 'A']
        );

        $producto = $this->createTestProduct('Producto Test Commit 1');

        $lote = Lote::create([
            'lote' => 'LOTE-C1-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'cantidad' => 10,
            'cantidad_disponible' => 10,
            'costo_individual' => 50,
            'fecha_vencimiento' => Carbon::now()->addYear()->toDateString(),
            'estado' => 'Completo',
        ]);

        $serie = SerieProducto::create([
            'numero_serie' => 'SN-C1-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'lote_id' => $lote->id,
            'codigo_lote' => $lote->lote,
            'estado_id' => $estadoEnStock->id,
        ]);

        $cliente = Cliente::first() ?? Cliente::create([
            'nombre' => 'Cliente Test',
            'tipo_documento' => 'DNI',
            'documento' => '12345678',
        ]);

        $notaVenta = NotaVenta::create([
            'cod_nota_venta' => 'NV-C1-' . uniqid(),
            'cliente_id' => $cliente->id,
            'fecha_emision' => Carbon::today()->toDateString(),
        ]);

        // Disparar observer mediante creación de NotaVentaRegistro
        $registroNV = NotaVentaRegistro::create([
            'nota_venta_id' => $notaVenta->id,
            'serie_id' => $serie->id,
            'numero_serie' => $serie->numero_serie,
            'lote_id' => $lote->id,
            'cantidad' => 1,
        ]);

        // 1. Serie debe pasar a 'Vendido'
        $serie->refresh();
        $this->assertEquals($estadoVendido->id, $serie->estado_id);

        // 2. GarantiaSerie debe haber sido creada con estado 'Vigente'
        $garantia = GarantiaSerie::where('serie_id', $serie->id)->first();
        $this->assertNotNull($garantia);
        $this->assertEquals('Vigente', $garantia->estado_garantia);
        $this->assertEquals(Carbon::today()->toDateString(), Carbon::parse($garantia->fecha_venta)->toDateString());
        $this->assertEquals(Carbon::today()->addMonths(12)->toDateString(), Carbon::parse($garantia->fecha_vencimiento)->toDateString());

        // 3. Lote cantidad_disponible disminuyó
        $lote->refresh();
        $this->assertEquals(9, $lote->cantidad_disponible);
    }

    /**
     * Test Commit 2 (823bd98) + Integración con modelo normalizado:
     * BusquedaSerieController retorna trazabilidad completa (comprobante, cliente,
     * garantía calculada con garantiaActual y estadoProducto).
     */
    public function test_commit2_busqueda_serie_controller_trazabilidad_y_modelo_normalizado()
    {
        $estado = EstadoProducto::firstOrCreate(
            ['nombre_estado' => 'En Stock'],
            ['ubicacion' => 'Almacén Principal', 'calidad' => 'A']
        );

        $producto = $this->createTestProduct('Laptop Test');

        $lote = Lote::create([
            'lote' => 'LOTE-TRAZA-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'cantidad' => 10,
            'cantidad_disponible' => 10,
            'costo_individual' => 50,
            'fecha_vencimiento' => Carbon::now()->addYear()->toDateString(),
            'estado' => 'Completo',
        ]);

        $serie = SerieProducto::create([
            'numero_serie' => 'SN-TRAZA-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'lote_id' => $lote->id,
            'codigo_lote' => $lote->lote,
            'estado_id' => $estado->id,
        ]);

        GarantiaSerie::create([
            'serie_id' => $serie->id,
            'estado_garantia' => 'Vigente',
            'fecha_venta' => Carbon::today()->subMonths(1)->toDateString(),
            'fecha_vencimiento' => Carbon::today()->addMonths(11)->toDateString(),
            'duracion_meses' => 12,
        ]);

        $cliente = Cliente::first() ?? Cliente::create([
            'nombre' => 'Corporacion Alpha',
            'telefono' => '999888777',
            'email' => 'alpha@test.com',
            'documento' => '20123456789',
        ]);

        $notaVenta = NotaVenta::create([
            'cod_nota_venta' => 'NV-TRAZA-001',
            'cliente_id' => $cliente->id,
            'fecha_emision' => Carbon::today()->subMonths(1)->toDateString(),
        ]);

        NotaVentaRegistro::create([
            'nota_venta_id' => $notaVenta->id,
            'serie_id' => $serie->id,
            'lote_id' => $lote->id,
            'cantidad' => 1,
        ]);

        $user = \App\User::first() ?? \App\User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('secret'),
        ]);

        // Simular petición AJAX a BusquedaSerieController
        $response = $this->actingAs($user)->postJson(route('lotes-garantias.ajax.busqueda-serie'), [
            'numero_serie' => $serie->numero_serie,
        ]);

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertTrue($data['success']);
        $this->assertTrue($data['encontrado']);
        $this->assertEquals($serie->numero_serie, $data['serie']['numero_serie']);
        $this->assertEquals($cliente->nombre, $data['serie']['cliente']['nombre_cliente']);
        $this->assertEquals('NV-TRAZA-001', $data['serie']['cliente']['numero_factura']);
        $this->assertEquals('Vigente', $data['serie']['garantia']['estado']);
        $this->assertNotEquals('--', $data['serie']['garantia']['fecha_vencimiento']);
        $this->assertEquals('En Stock', $data['serie']['estado']['condicion']);
    }

    /**
     * Test Commit 3 (0ad3e3e): Motor de Reglas GarantiaRulesEngineService con null-safety,
     * evaluación de defectos de fábrica y exclusiones.
     */
    public function test_commit3_motor_de_reglas_null_safety_y_exclusiones()
    {
        $engine = app(GarantiaRulesEngineService::class);

        $serie = SerieProducto::create([
            'numero_serie' => 'SN-RULES-' . uniqid(),
            'codigo_producto' => 'PROD-RULES',
        ]);

        // 1. Sin garantía activa -> Rechazado por falta de garantía
        $veredictoSinGarantia = $engine->evaluarCobertura($serie, 'defecto de fabrica');
        $this->assertEquals(VeredictoGarantia::RECHAZADO_EXCLUSION, $veredictoSinGarantia->estado());
        $this->assertStringContainsString('no cuenta con un registro de garantía', $veredictoSinGarantia->mensaje());

        // Asignar garantía vigente
        GarantiaSerie::create([
            'serie_id' => $serie->id,
            'estado_garantia' => 'Vigente',
            'fecha_venta' => Carbon::today()->subMonths(2)->toDateString(),
            'fecha_vencimiento' => Carbon::today()->addMonths(10)->toDateString(),
            'duracion_meses' => 12,
        ]);
        $serie->refresh();

        // 2. Defecto de fábrica dentro de vigencia -> Aprobado automático
        $veredictoFabrica = $engine->evaluarCobertura($serie, 'defecto de fabrica');
        $this->assertEquals(VeredictoGarantia::APROBADO_AUTOMATICO, $veredictoFabrica->estado());

        // 3. Exclusión por daño físico -> Rechazado
        $veredictoDano = $engine->evaluarCobertura($serie, 'daño físico');
        $this->assertEquals(VeredictoGarantia::RECHAZADO_EXCLUSION, $veredictoDano->estado());
        $this->assertStringContainsString('daño físico', $veredictoDano->mensaje());

        // 4. Desgaste normal -> Escalar a técnico
        $veredictoDesgaste = $engine->evaluarCobertura($serie, 'desgaste');
        $this->assertEquals(VeredictoGarantia::ESCALAR_TECNICO, $veredictoDesgaste->estado());
    }

    /**
     * Test Commit 3 (0ad3e3e) + Commit 4 (89a710b): ReclamoClienteController
     * Flujo multi-actor completo (Aprobado crea GarantiaProveedor, Escalar crea OrdenServicio,
     * persistencia de evidencias en ArchivoEvidenciaGarantia y soporte Web/API).
     */
    public function test_commit3_y_commit4_reclamo_cliente_controller_flujo_multi_actor()
    {
        $proveedor = Provedor::first() ?? Provedor::create([
            'nombre' => 'Proveedor Global Test',
            'ruc' => '20123456780',
        ]);

        $cliente = Cliente::first() ?? Cliente::create([
            'nombre' => 'Cliente Reclamo Test',
            'tipo_documento' => 'DNI',
            'documento' => '87654321',
        ]);

        $producto = $this->createTestProduct('Monitor Gamer');

        $lote = Lote::create([
            'lote' => 'LOTE-REC-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'proveedor_id' => $proveedor->id,
            'cantidad' => 10,
            'cantidad_disponible' => 10,
        ]);

        $serie = SerieProducto::create([
            'numero_serie' => 'SN-REC-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'lote_id' => $lote->id,
            'codigo_lote' => $lote->lote,
        ]);

        GarantiaSerie::create([
            'serie_id' => $serie->id,
            'estado_garantia' => 'Vigente',
            'fecha_venta' => Carbon::today()->subMonths(1)->toDateString(),
            'fecha_vencimiento' => Carbon::today()->addMonths(11)->toDateString(),
            'duracion_meses' => 12,
        ]);

        // Vinculación mediante comprobante
        $notaVenta = NotaVenta::create([
            'cod_nota_venta' => 'NV-REC-001',
            'cliente_id' => $cliente->id,
            'fecha_emision' => Carbon::today()->toDateString(),
        ]);
        NotaVentaRegistro::create([
            'nota_venta_id' => $notaVenta->id,
            'serie_id' => $serie->id,
            'cantidad' => 1,
        ]);

        // 1. Caso Aprobado Automático (Defecto de fábrica con evidencias)
        $archivoEvidencia = UploadedFile::fake()->image('evidencia_falla.jpg');

        $payload = [
            'numero_serie' => $serie->numero_serie,
            'tipo_falla' => 'defecto de fabrica',
            'descripcion' => 'Pantalla parpadea con líneas horizontales de fábrica al encender.',
            'evidencias' => [$archivoEvidencia],
        ];

        $response = $this->postJson(route('reclamo_cliente.store'), $payload);

        $response->assertStatus(201);
        $data = $response->json();
        $this->assertTrue($data['success']);
        $this->assertEquals(VeredictoGarantia::APROBADO_AUTOMATICO, $data['estado']);

        // Verificar persistencia de ReclamoGarantia
        $reclamo = ReclamoGarantia::find($data['reclamo_id']);
        $this->assertNotNull($reclamo);
        $this->assertEquals('Aprobado', $reclamo->estado);
        $this->assertEquals($cliente->id, $reclamo->cliente_id);

        // Verificar persistencia en ArchivoEvidenciaGarantia
        $evidencia = ArchivoEvidenciaGarantia::where('reclamo_garantia_id', $reclamo->id)->first();
        $this->assertNotNull($evidencia);
        $this->assertStringContainsString('reclamos/' . $serie->id, $evidencia->ruta_archivo);

        // Verificar creación de GarantiaProveedor (Back to back)
        $garantiaProv = GarantiaProveedor::where('reclamo_garantia_id', $reclamo->id)->first();
        $this->assertNotNull($garantiaProv);
        $this->assertEquals($proveedor->id, $garantiaProv->proveedor_id);

        // Verificar despacho de notificación B2B
        Queue::assertPushed(NotificarProveedorReclamoB2B::class);

        // 2. Caso Escalar a Técnico (Falla por desgaste)
        $serie2 = SerieProducto::create([
            'numero_serie' => 'SN-REC-TEC-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'lote_id' => $lote->id,
        ]);
        GarantiaSerie::create([
            'serie_id' => $serie2->id,
            'estado_garantia' => 'Vigente',
            'fecha_venta' => Carbon::today()->subMonths(1)->toDateString(),
            'fecha_vencimiento' => Carbon::today()->addMonths(11)->toDateString(),
            'duracion_meses' => 12,
        ]);
        NotaVentaRegistro::create([
            'nota_venta_id' => $notaVenta->id,
            'serie_id' => $serie2->id,
            'cantidad' => 1,
        ]);

        $responseTec = $this->postJson(route('reclamo_cliente.store'), [
            'numero_serie' => $serie2->numero_serie,
            'tipo_falla' => 'desgaste',
            'descripcion' => 'Desgaste acelerado en conectores tras un mes de uso regular.',
        ]);

        $responseTec->assertStatus(201);
        $dataTec = $responseTec->json();
        $this->assertEquals(VeredictoGarantia::ESCALAR_TECNICO, $dataTec['estado']);

        // Verificar creación de OrdenServicio para peritaje técnico
        $ordenServicio = OrdenServicio::where('reclamo_garantia_id', $dataTec['reclamo_id'])->first();
        $this->assertNotNull($ordenServicio);
        $this->assertEquals('Pendiente', $ordenServicio->estado);

        // 3. Caso Web Form: Envío con redirección HTML
        $serie3 = SerieProducto::create([
            'numero_serie' => 'SN-REC-WEB-' . uniqid(),
            'producto_id' => $producto->id,
            'codigo_producto' => $producto->codigo_producto,
            'lote_id' => $lote->id,
        ]);
        GarantiaSerie::create([
            'serie_id' => $serie3->id,
            'estado_garantia' => 'Vigente',
            'fecha_venta' => Carbon::today()->toDateString(),
            'fecha_vencimiento' => Carbon::today()->addMonths(12)->toDateString(),
            'duracion_meses' => 12,
        ]);
        NotaVentaRegistro::create([
            'nota_venta_id' => $notaVenta->id,
            'serie_id' => $serie3->id,
            'cantidad' => 1,
        ]);

        $user = \App\User::first() ?? \App\User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('secret'),
        ]);

        $responseWeb = $this->actingAs($user)->post(route('lotes-garantias.reclamo-cliente.store'), [
            'numero_serie' => $serie3->numero_serie,
            'tipo_falla' => 'defecto de fabrica',
            'descripcion' => 'Equipo no enciende al conectarlo directamente del empaque original.',
        ]);

        $responseWeb->assertRedirect(route('lotes-garantias.reclamo-cliente', ['codigo_producto' => $producto->codigo_producto]));
        $responseWeb->assertSessionHas('success');
    }
}
