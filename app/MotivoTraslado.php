<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class MotivoTraslado extends Model
{
	protected $table = 'motivo_traslado';

	protected $guarded = [];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }


    public static function mot_tras($mt_tr){

        // $mt_tr = $lett\;
        switch ($mt_tr) {
            case 'Venta':
                $value_cod = 01;
                break;
            case 'Venta sujeta a confirmación del comprobador':
                $value_cod = 14;
                break;
            case 'Compra':
                $value_cod = 02;
                break;
            case 'Consignación':
                $value_cod = 01;
                break;
            case 'Devolución':
                $value_cod = 01;
                break;
            case 'traslado entre Establecimiento de la misma Empresa':
                $value_cod = 01;
                break;
            case 'Traslado de bienes para Transformación':
                $value_cod = 01;
                break;
            case 'Recojo de bienes':
                $value_cod = 01;
                break;
            case 'Traslado por bienes itinerante  de comprobante de pago':
                $value_cod = 01;
                break;
            case 'Traslado zona primaria':
                $value_cod = 01;
                break;
            case 'Importación':
                $value_cod = 01;
                break;
            case 'Exportación':
                $value_cod = 01;
                break;
            case 'Venta con entrega a terceros':
                $value_cod = 01;
                break;
            case 'Otros':
                $value_cod = 01;
                break;
        }

        return $value_cod;
    }
}
