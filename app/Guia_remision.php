<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Guia_remision extends Model
{
    protected $table = 'guia_remision';

    protected $guarded = [];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function user_personal()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'conductor_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
    public function vehiculo_publicos()
    {
        return $this->belongsTo(TransportePublico::class, 'vehiculo_publico');
    }
    // public function motivo_traslado(){
    //     return $this->belongsTo(MotivoTraslado::class,'cliente_id');
    // }   
    public function registros()
    {
        return $this->hasMany(g_remision_registro::class, 'guia_remision_id');
    }

    public function getFechaEmisionAttribute()
    {
        $new_emision = Carbon::parse($this->attributes['fecha_emision'])->format('d/m/Y');
        return $new_emision;
    }
    public static function count_month_comprobantes($fecha)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $remision  = Guia_remision::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $total_cli = $remision->pluck('cliente_id')->unique()->count();

        $mes = array(
            "cantidad" => $remision->count(),
            "clientes" => $total_cli
        );
        return $mes;
    }
    public static function estado_sunat($id)
    {
        $guia_remision = Guia_remision::find($id);
        switch ($guia_remision->g_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }
    public static function normalizar_fechas($fecha)
    {
        if (empty($fecha)) {
            return null;
        }

        $formatos = ['Y-m-d', 'd/m/Y', 'Y-m-d H:i:s', 'd-m-Y'];
        foreach ($formatos as $formato) {
            try {
                return Carbon::createFromFormat($formato, $fecha)->format('d-m-Y');
            } catch (\Exception $e) {
                // sigue probando con el siguiente formato
            }
        }
    }

    public static function devolucion_guia_remision($id)
    {
        try {
            $cambio = TipoCambio::where('fecha', Carbon::now()->format('Y-m-d'))->first();
            $registro_gr = Tipo_Registro::where('id', '=', '5')->first();
            if (!isset($registro_gr)) {
                $registro_nc = new Tipo_Registro;
                $registro_nc->nombre = "Guia Remision";
                $registro_nc->informacion = "devolucion por guia de remision";
                $registro_nc->save();
            }
            $ultima_entrada = Kardex_entrada::where('tipo_registro_id', '=', '5')->orderby('created_aT', 'DESC')->first();
            if (isset($ultima_entrada)) {
                $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
                $numero++;
                $cantidad_registro = str_pad($numero, 8, "0", STR_PAD_LEFT);
                $codigo_guia = 'DEV.GR' . '-' . $cantidad_registro;
            } else {
                $cantidad_registro = str_pad('1', 8, "0", STR_PAD_LEFT);
                $codigo_guia = 'DEV.GR' . '-' . $cantidad_registro;
            }

            $guia_remision = Guia_remision::find($id);
            $guia_registros = $guia_remision->registros;

            $kardex_entrada = new Kardex_entrada();
            $kardex_entrada->motivo_id = 3;
            $kardex_entrada->codigo_guia = $codigo_guia;
            $kardex_entrada->provedor_id = 1;
            $kardex_entrada->guia_remision = $guia_remision->cod_guia;
            $kardex_entrada->categoria_id = '1';
            $kardex_entrada->factura = "0";
            $kardex_entrada->almacen_id = $guia_remision->almacen_id;
            $kardex_entrada->almacen_emisor_id = $guia_remision->almacen_id;
            $kardex_entrada->almacen_receptor_id = $guia_remision->almacen_id;
            $kardex_entrada->moneda_id = 1;
            $kardex_entrada->tipo_registro_id = 4;
            $kardex_entrada->estado = 0;
            $kardex_entrada->user_id = auth()->user()->id;
            $kardex_entrada->informacion = "SE HIZO DEVOLUCION ADJUNTO " . $codigo_guia;
            $kardex_entrada->save();


            foreach ($guia_registros as $key => $registros) {
                // Creacion del registro de la devolucion
                $kardex_entrada_registro = new kardex_entrada_registro();
                $kardex_entrada_registro->kardex_entrada_id = $kardex_entrada->id;
                $kardex_entrada_registro->producto_id = $registros->producto_id;
                $kardex_entrada_registro->cantidad_inicial = $registros->cantidad;
                $kardex_entrada_registro->precio_nacional = 0;
                $kardex_entrada_registro->precio_extranjero = 0;
                $kardex_entrada_registro->cambio = $cambio->compra;
                $kardex_entrada_registro->cantidad = 0;
                $kardex_entrada_registro->estado_devolucion = 1;
                $kardex_entrada_registro->almacen_id = $kardex_entrada->almacen_id;
                $kardex_entrada_registro->estado = 0;
                $kardex_entrada_registro->tipo_registro_id = 2;
                $kardex_entrada_registro->save();

                $almacen = $guia_remision->almacen_id;
                $kardex_entrada_get = Kardex_entrada::where('almacen_id', $almacen)->get();
                $kardex_entrada_count = Kardex_entrada::where('almacen_id', $almacen)->count();

                foreach ($kardex_entrada_get as $kardex_entradas) {
                    $kadex_entrada_id[] = $kardex_entradas->id;
                }

                for ($x = 0; $x < $kardex_entrada_count; $x++) {
                    if (Kardex_entrada_registro::where('producto_id', $kardex_entrada_registro->producto_id)->where('kardex_entrada_id', $kadex_entrada_id[$x])->first()) {
                        $nueva[] = Kardex_entrada_registro::where('producto_id', $kardex_entrada_registro->producto_id)->where('kardex_entrada_id', $kadex_entrada_id[$x])->first();
                    }
                }

                $comparacion = $nueva;
                // return $comparacion;
                //buble para la cantidad
                $cantidad_requerida = 0;
                foreach ($comparacion as $comparaciones) {
                    $cantidad_requerida = $comparaciones->cantidad + $cantidad_requerida;
                }

                $cantidad = $registros->cantidad;
                $logica = $registros->cantidad;

                // return $comparacion;

                if (isset($comparacion)) {
                    $var_cantidad_entrada = $registros->cantidad;
                    $contador = 0;

                    foreach ($comparacion as $p) {
                        if ($p->cantidad + $cantidad < $p->cantidad_inicial) {
                            // return $p->cantidad+$logica;
                            $p->cantidad = $p->cantidad + $logica;
                            $p->estado = 1;
                            $p->save();
                            // return "guarda";
                            break;
                        } else {
                            $logica = ($logica - $p->cantidad_inicial) + $p->cantidad;
                            $p->cantidad = $p->cantidad_inicial;
                            $p->estado = 1;
                            $p->save();
                            continue;
                        }
                    }
                }

                $cant = $registros->cantidad;
                Stock_almacen::ingreso($guia_remision->almacen_id, $kardex_entrada_registro->producto_id, $cant);

                kardex_entrada_registro::stock_producto_precio();

                unset($nueva);
            }

             return response()->json([
                'success' => true,
                'message' => 'Se efectuó el re stock de los produtos en la guia de remison:',
            ], 500);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
