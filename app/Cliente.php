<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    
    protected $fillable = [
        'nombre',
        'direccion',
        'email',
        'telefono',
        'anexo',
        'celular',
        'empresa',
        'documento_identificacion',
        'numero_documento',
        'ciudad',
        'departamento',
        'pais',
        'tipo_cliente',
        'cod_postal',
        'aniversario',
        'fecha_registro',
    ];
    
    protected $guarded = [];

    public static function cliente_update($id_cliente){
        $cliente = Cliente::where('id',$id_cliente)->first();
        if(empty($cliente->empresa)){
            $cliente->empresa = $cliente->nombre;
            $cliente->save();
        }
        if(empty($cliente->ubigeo)){
            $cliente->cod_postal = '150101';
            $cliente->save();
        }
    }

    public static function revision_contacto($cliente_id){
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
}
