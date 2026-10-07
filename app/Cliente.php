<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'direccion',
        'email',
        'telefono',
        'celular',
        'empresa',
        'numero_documento'
    ];

    protected $guarded = [];

    public function vendedor_asignado(){
        return $this->belongsTo(Personal_venta::class, 'vendedor_id');
    }

    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }

    public static function cliente_update($id_cliente)
    {
        $cliente = Cliente::where('id', $id_cliente)->first();
        if (empty($cliente->empresa)) {
            $cliente->empresa = $cliente->nombre;
            $cliente->save();
        }
        if (empty($cliente->ubigeo)) {
            $cliente->cod_postal = '150101';
            $cliente->save();
        }
    }

    public static function revision_contacto($cliente_id)
    {
        // $clientes = Cliente::find($cliente_id);
        // foreach ($clientes as $cli) {
        $cont = Contacto::where('clientes_id', $cliente_id)->first();
        if (!$cont) {
            $cont = Contacto::firstOrCreate(
                ['clientes_id' => $cliente_id],
                [
                    'primer_contacto' => 1,
                    'nombre' => 'Contacto',
                    'cargo' => 'Cargo',
                    'telefono' => '0050000',
                    'celular' => '951000000',
                    'email' => 'correo@contacto.com',
                    'estado' => 0,
                ]
            );
        }
        //     $cont_2[] = $cont->id;
        // // }/
    }

    public function servicioGuia(){
        return $this->hasMany(ServicioGuia::class, 'cliente_id', 'id');
    }

    public static function count_mes($mes_año)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $mes_año)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $clientes  = Cliente::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        return $clientes;
    }

    public function getTipoClienteSearchAttribute(){
        $tipo = $this->attributes['tipo_cliente'];
        switch ($tipo) {
            case '1':
                return "Cliente Frecuente";
                break;
            case '2':
                return "Cliente Revendedor";
                break;
            case '3':
                return "Cliente Vip";
                break;
            default:
                return $tipo;
                break;
        }
    }
}
