<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'codigo_servicio',
        'codigo_original',
        'nombre',
        'descripcion',
        'marca_id',
        'familia_id',
        'subfamilia_id',
        'categoria',
        'precio_nacional',
        'precio_extranjero',
        'utilidad',
        'descuento',
        'tipo_afectacion_id',
        'moneda_id',
        'foto',
        'estado_activo',
        'estado_anular'
    ];

    protected $guarded = [];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }
    public function familia()
    {
        return $this->belongsTo(Familia::class, 'familia_id');
    }
    public function subfamilia_i_serv()
    {
        return $this->belongsTo(Subfamilia::class, 'subfamilia_id');
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function tipo_afec_i_serv()
    {
        return $this->belongsTo(Tipo_afectacion::class, 'tipo_afectacion_id');
    }

    public static function porcentaje_servicios()
    {

        // SERVICIOS CREADOS HOY
        $serv_act_count_day = Servicios::where('estado_anular', '0')->whereDate('created_at', Carbon::today())->count();
        $serv_anu_count_day = Servicios::where('estado_anular', '1')->whereDate('updated_at', Carbon::today())->count();

        $servicios = Servicios::count();
        if ($servicios === 0) {
            $data = [
                'total' => $servicios,
                'activos' => 0,
                'inactivos' => 0,
                'anulados' => 0
            ];
            return $data;
        }
        $servicio_activos = Servicios::where('estado_anular', '0')->count();
        $servicio_anulados = Servicios::where('estado_anular', 1)->count();

        $data = [
            'total' => $servicios,
            'activos' => $servicio_activos,
            'anulados' => $servicio_anulados,
            'cantidad_hoy_creados' => $serv_act_count_day,
            'cantidad_hoy_anulados' => $serv_anu_count_day,
        ];
        return $data;
    }

    public function calcularPrecios()
    {
        // $servicio = Servicios::where('estado_anular',0)->get();
        $moneda = Moneda::where('principal', 1)->first();
        $moneda_nacional = Moneda::where('tipo', 'nacional')->first();
        $moneda_extranjera = Moneda::where('tipo', 'extranjera')->first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $igv = Igv::first();


        $precioNac = floatval($this->precio_nacional);
        $precioExt = floatval($this->precio_extranjero);
        $utilidad = $this->utilidad / 100;
        $tc = $tipo_cambio->paralelo; // tipo de cambio

        // Variables para retorno
        $resultado = [
            'nacional'   => [],
            'extranjero' => []
        ];

        if ($moneda->principal == 1) {
            // Caso 1: moneda principal del sistema
            if ($moneda->tipo == 'nacional') {
                // Precio nacional
                $precio_nacional = round($precioNac + ($precioNac * $utilidad), 2);
                // Precio extranjero convertido
                $precio_extranjero = round($precioExt + ($precioExt * $utilidad), 2);
            } else {
                // Precio extranjero
                $precio_extranjero = round($precioExt + ($precioExt * $utilidad), 2);
                // Precio nacional convertido
                $precio_nacional = round($precioNac + ($precioNac * $utilidad), 2);
            }
        } else {
            // Caso 2: moneda secundaria del sistema
            if ($moneda->tipo == 'extranjera') {
                // Precio nacional convertido a extranjero
                $precio_nacional = round(($precioNac + ($precioNac * $utilidad)) / $tc, 2);
                // Precio extranjero directo
                $precio_extranjero = round($precioExt + ($precioExt * $utilidad), 2);
            } else {
                // Precio extranjero convertido a nacional
                $precio_extranjero = round(($precioExt + ($precioExt * $utilidad)) * $tc, 2);
                // Precio nacional directo
                $precio_nacional = round($precioNac + ($precioNac * $utilidad), 2);
            }
        }



        // $esNacional = $moneda->tipo === 'nacional';

        // $utilidad = $this->utilidad - $this->descuento;
        // // $campoPrecioBase = $esNacional ? 'precio_nacional' : 'precio_extranjero';
        // $utilidadPrecio = floatval($this->precio_nacional) * ($utilidad / 100);
        // $precio_nacional = round(floatval($this->precio_nacional) + $utilidadPrecio, 2);
        // if ($esNacional) {
        //     $precio_extranjero = round((floatval($this->precio_extranjero) + $utilidadPrecio) / $tipo_cambio->paralelo, 2);
        // } else {
        //     $precio_extranjero = round((floatval($this->precio_extranjero) + $utilidadPrecio) * $tipo_cambio->paralelo, 2);
        // }
        return [
            'precio_nacional' => $moneda_nacional->simbolo . ' ' . number_format($precio_nacional, 2),
            'precio_nacional_igv' => $moneda_nacional->simbolo . ' ' . number_format(round($precio_nacional + ($precio_nacional * ($igv->igv_total / 100)), 2), 2),
            'precio_extranjero' => $moneda_extranjera->simbolo . ' ' . number_format(($precio_extranjero), 2),
            'precio_extranjero_igv' => $moneda_extranjera->simbolo . ' ' . number_format(round($precio_extranjero + ($precio_extranjero * ($igv->igv_total / 100)), 2), 2),
        ];
    }

    public static function generar_codigo()
    {
        $conteo = Servicios::all()->count();
        $suma = $conteo + 1;
        $servicio_nr = str_pad($suma, 8, "0", STR_PAD_LEFT);
        $codigo_servicio = "SERV-" . $servicio_nr;
        return $codigo_servicio;
    }
}
