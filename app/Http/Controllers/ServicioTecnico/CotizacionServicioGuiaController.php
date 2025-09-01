<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Almacen;
use App\Cliente;
use App\Codigo_guia_almacen;
use App\CotizacionManual;
use App\CotizacionManual_registros;
use App\Empresa;
use App\Forma_pago;
use App\Garantia;
use App\Http\Controllers\Controller;
use App\Igv;
use App\Kardex_entrada;
use App\Moneda;
use App\Producto;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use App\Servicios;
use App\Tipo_operacion_f;
use App\TipoCambio;
use App\Validez;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CotizacionServicioGuiaController extends Controller
{
    public function index() {
        return view('servicio_tecnico.cotizaciones_servicio_tecnico.index');
    }

    public function createServicioGuiaCotizacionM($servicio_g_id)
    {
        // cotizar un servicio tecnico al cliente
        $servicioGuia = ServicioGuia::findOrFail($servicio_g_id);
        // equipos ingresados al servicio tecnico
        $ingresoEquipos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->get();

        $garantia=Garantia::where('estado',0)->get();
        $validez=Validez::where('estado',0)->get();
        if (count($garantia)==0) {
            $garantia_new=new Garantia;
            $garantia_new->descripcion='Sin Garantia';
            $garantia_new->estado='0';
            $garantia_new->save();
        }
        if (count($validez)==0) {
            $validez_new=new Validez;
            $validez_new->descripcion='1 dia';
            $validez_new->estado='0';
            $validez_new->save();
        }
        // Migracion nueva
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // * CAMBIAR POR VERIFICACION DE CANTIDAD DE PRODUCTOS Y SERVICIOS PRODUCTOS??
        $existe_id=Kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){
        //     return redirect()->route('kardex-entrada.index');
        // }
        // Sucursal
        $sucursal_1=1;
        $sucursal=Almacen::where('id',$sucursal_1)->first();

        // Validador de contador en productos y servicios
        $inventario_inicial=Producto::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados ']);
        }

        $almacen = Almacen::where('estado','!=',1)->get();
        //Numero de factura
        $cotizacion_fact=CotizacionManual::where('almacen_id',$sucursal->id)->where('tipo','factura')->latest()->first();
        if (empty($cotizacion_fact)) {
            $numero_serie_fac=$sucursal->id;
            $correlativo_fac=1;
        } else{
            $numero_serie_busqueda_fac=$cotizacion_fact->cod_cotizacion;
            $numero_serie_1_fac=strstr($numero_serie_busqueda_fac,'0',false);
            $numero_serie_fac=strstr($numero_serie_1_fac,'-',true);
            $correlativo_ultimo_fac=substr(strrchr($numero_serie_busqueda_fac, "-"),1);
            $correlativo_fac = $correlativo_ultimo_fac+1;

            if($correlativo_ultimo_fac == 99999999){
                $correlativo_fac = 1;
                $numero_serie_fac = $numero_serie_fac+1;
            }
        }
        $sucursal_nr_fac = str_pad($numero_serie_fac, 3, "0", STR_PAD_LEFT);
        $correlativo_fac=str_pad($correlativo_fac, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero_fac="CMF ".$sucursal_nr_fac."-".$correlativo_fac;

        $clientes=Cliente::all();
        //$moneda=Moneda::where('principal','1')->first();
        $moneda=Moneda::get();
        $forma_pagos= Forma_pago::all();
        $igv=Igv::first();
        $servicios = Servicios::all();
        $productos=Producto::all();
        $empresa=Empresa::first();
        $tipo_operacion=Tipo_operacion_f::get();
        // return view('servicio_tecnico.servicios_cotizacion.create_cotizacion_servicios_guias',compact('garantia','validez','igv','empresa','clientes','forma_pagos','moneda','productos','servicios','almacen','tipo_operacion','sucursal','cotizacion_numero_fac'));
        return view('transaccion.venta.cotizacion.manual.create', [
            'garantia' => $garantia,
            'validez' => $validez,
            'igv' => $igv,
            'empresa' => $empresa,
            'clientes' => $clientes,
            'forma_pagos' => $forma_pagos,
            'moneda' => $moneda,
            'productos' => $productos,
            'servicios' => $servicios,
            'almacen' => $almacen,
            'tipo_operacion' => $tipo_operacion,
            'sucursal' => $sucursal,
            'cotizacion_numero_fac' => $cotizacion_numero_fac,
            'servicioGuia' => $servicioGuia,
            'ingresoEquipos' => $ingresoEquipos
        ]);
    }
}
