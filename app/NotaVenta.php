<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NotaVenta extends Model
{
    protected $table = 'nota_venta';

    protected $guarded = [];
       public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
     public function user(){
        return $this->belongsTo(User::class,'user_registrado');
    }
     public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
     public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago');
    }
     public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

    
    public static function count_mes($fecha) {
        // CANTIDAD DE COTIZACIONES Formato = "02-09-2023"
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $nota_venta = NotaVenta::whereDate('created_at', '=', $fecha_conv)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        $suma = 0;
        //$total = 0;
        foreach ($nota_venta as $notaV) {
            
            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $notaV->id)->get();
            
            foreach ($nota_venta_reg as $nota_venta_regs) {
                // Condicional para soles
                if ($moneda->id == "1") { // Si es soles
                    if ($notaV->moneda->id == "1") { // Soles
                        $total = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;  
                    } else { // Dólares
                        $subtotal = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;    
                        $total = $subtotal * $notaV->cambio;
                    }
                } else { // Si no, retorno dólares
                    if ($notaV->moneda->id == "1") { // Soles
                        $subtotal = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;    
                        $total = $subtotal / $notaV->cambio;
                    } else { // Dólares
                        $total = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;   
                    }
                }
                return $total;
            }
            $suma += $total; // Mueve la suma aquí para acumular los totales
        }
    
        $mes = array(
            "cantidad" => $nota_venta->count(),
            "total" => $suma
        );
    
        return $total;
    }
}