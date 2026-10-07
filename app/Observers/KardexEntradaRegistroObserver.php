<?php

namespace App\Observers;

use App\EstadoProducto;
use App\Kardex_entrada;
use App\Lote;
use App\Producto;
use App\Stock_producto;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class KardexEntradaRegistroObserver
{
    /**
     * Handle the kardex_entrada_registro "created" event.
     * Genera automáticamente el lote e inserta masivamente las series del producto.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     * @throws Throwable
     */
    public function created(kardex_entrada_registro $kardexEntradaRegistro)
    {
        // 1. Generación de Lote y Series en transacción atómica
        try {
            DB::transaction(function () use ($kardexEntradaRegistro): void {
                $producto = Producto::find($kardexEntradaRegistro->producto_id);
                $codigoProducto = $producto ? $producto->codigo_producto : ('PROD-' . $kardexEntradaRegistro->producto_id);

                $kardexEntrada = Kardex_entrada::with('provedor')->find($kardexEntradaRegistro->kardex_entrada_id);
                $proveedorId = $kardexEntrada ? $kardexEntrada->provedor_id : null;
                $proveedorNombre = ($kardexEntrada && $kardexEntrada->provedor) ? $kardexEntrada->provedor->empresa : null;

                $cantidad = (int) ($kardexEntradaRegistro->cantidad ?? $kardexEntradaRegistro->unidad_cantidad ?? 1);
                $costoUnitario = (float) ($kardexEntradaRegistro->precio_nacional ?? 0.0);
                $codigoLote = sprintf('LOT-%s-%04d', Carbon::now()->format('Ymd'), (int) $kardexEntradaRegistro->id);

                // Crear Lote
                $lote = Lote::create([
                    'lote'                       => $codigoLote,
                    'producto_id'                => $kardexEntradaRegistro->producto_id,
                    'codigo_producto'           => $codigoProducto,
                    'almacen_id'                 => $kardexEntradaRegistro->almacen_id,
                    'proveedor_id'               => $proveedorId,
                    'proveedor_nombre'           => $proveedorNombre,
                    'cantidad'                   => $cantidad,
                    'cantidad_disponible'        => $cantidad,
                    'costo_individual'           => $costoUnitario,
                    'fecha_produccion'           => Carbon::now()->toDateString(),
                    'fecha_vencimiento'          => Carbon::now()->addYears(2)->toDateString(),
                    'estado'                     => 'Completo',
                    'kardex_entrada_registro_id' => $kardexEntradaRegistro->id,
                ]);

                // Inserción masiva de series en bloques
                $estadoEnStock = EstadoProducto::where('nombre_estado', 'En Stock')->first();
                $estadoId = $estadoEnStock ? $estadoEnStock->id : null;
                $now = Carbon::now()->toDateTimeString();

                $seriesBatch = [];
                for ($i = 1; $i <= $cantidad; $i++) {
                    $seriesBatch[] = [
                        'numero_serie'            => sprintf('SN-%s-%s-%04d', $codigoProducto, $codigoLote, $i),
                        'producto_id'             => $kardexEntradaRegistro->producto_id,
                        'codigo_producto'         => $codigoProducto,
                        'lote_id'                 => $lote->id,
                        'codigo_lote'             => $codigoLote,
                        'estado_id'               => $estadoId,
                        'fecha_ultimo_movimiento' => $now,
                        'created_at'              => $now,
                        'updated_at'              => $now,
                    ];
                }

                foreach (array_chunk($seriesBatch, 500) as $chunk) {
                    DB::table('series_productos')->insert($chunk);
                }
            });
        } catch (Throwable $e) {
            Log::error(
                sprintf('Error en KardexEntradaRegistroObserver (Lotes/Series) para registro #%s: %s', (string) ($kardexEntradaRegistro->id ?? 'N/A'), $e->getMessage()),
                [
                    'exception'   => $e,
                    'registro_id' => $kardexEntradaRegistro->id ?? null,
                ]
            );

            throw $e;
        }

        // 2. Recálculo de Stock_producto (Precios Promedio)
        $stock_productos=Stock_producto::get();
        $stocks_activos = kardex_entrada_registro::where('estado',1)->get();

        foreach ($stocks_activos as $stocks_activo) {
           $productos[]=$stocks_activo->producto->id;
        }
        $prod=array_unique($productos, SORT_REGULAR);
        $count_cantidad=count($prod);

        for($x=0;$x<$count_cantidad;$x++){
            $cantidad[] = intval(kardex_entrada_registro::where('producto_id',$prod[$x])->sum('cantidad'));
        }
        //$prod -> los productos en orden
        //$cantidad -> obtiene el stock en orden al producto

        $contador=0;
        $array_registros[]=0;
        // $array_registros[]=3;
        for($x=0;$x<$count_cantidad;$x++){
            while($cantidad[$x] > $contador){
                $kardex_almacen_principal_desc= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereNotIn('id',$array_registros)->first();
                $contador=$contador+$kardex_almacen_principal_desc->cantidad_inicial;
                $array_registros[]=$kardex_almacen_principal_desc->id;
            }
            //llamar los kardex_registros que tengan los id
            $precio_nacional= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_nacional');
            $precio_extranjero= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_extranjero');
            //guardar en sotck_productos
            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$prod[$x])->sum('cantidad');
            $stock_producto=Stock_producto::where('producto_id',$prod[$x])->first();
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=$precio_nacional;
            $stock_producto->precio_extranjero=$precio_extranjero;
            $stock_producto->save();
            unset($array_registros);
            unset($contador);
            $array_registros[]=0;
            $contador=0;
        }

    }

    /**
     * Handle the kardex_entrada_registro "updated" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function updated(kardex_entrada_registro $kardexEntradaRegistro)
    {
        $stock_productos=Stock_producto::get();
        $stocks_activos = kardex_entrada_registro::where('estado',1)->get();

        foreach ($stocks_activos as $stocks_activo) {
           $productos[]=$stocks_activo->producto->id;
        }
        $prod=array_unique($productos, SORT_REGULAR);
        $count_cantidad=count($prod);

        for($x=0;$x<$count_cantidad;$x++){
            $cantidad[] = intval(kardex_entrada_registro::where('producto_id',$prod[$x])->sum('cantidad'));
        }
        // return $cantidad;
        //$prod -> los productos en orden
        //$cantidad -> obtiene el stock en orden al producto

        $kardex_almacen_principal_desc= kardex_entrada_registro::where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->get();
        $contador=0;
        $array_registros[]=0;
        // $array_registros[]=3;
        for($x=0;$x<$count_cantidad;$x++){
            while($cantidad[$x] > $contador){
                $kardex_almacen_principal_desc= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereNotIn('id',$array_registros)->get()->first();
                $contador=$contador+$kardex_almacen_principal_desc->cantidad_inicial;
                $array_registros[]=$kardex_almacen_principal_desc->id;
            }
            // return $cantidad;
            // return $kardex_almacen_principal_desc->cantidad_inicial;
            //llamar los kardex_registros que tengan los id
            $precio_nacional= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_nacional');
            $precio_extranjero= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_extranjero');
            //guardar en sotck_productos

            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$prod[$x])->sum('cantidad');
            $stock_producto=Stock_producto::where('producto_id',$prod[$x])->first();
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=$precio_nacional;
            $stock_producto->precio_extranjero=$precio_extranjero;
            $stock_producto->save();
            unset($array_registros);
            unset($contador);
            $array_registros[]=0;
            $contador=0;
        }

    }

    /**
     * Handle the kardex_entrada_registro "deleted" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function deleted(kardex_entrada_registro $kardexEntradaRegistro)
    {
        //
    }

    /**
     * Handle the kardex_entrada_registro "restored" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function restored(kardex_entrada_registro $kardexEntradaRegistro)
    {
        //
    }

    /**
     * Handle the kardex_entrada_registro "force deleted" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function forceDeleted(kardex_entrada_registro $kardexEntradaRegistro)
    {
        //
    }
}
