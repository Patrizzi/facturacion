<?php

namespace App;
use App\Almacen;
use App\Lote;
use App\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock_almacen extends Model
{
    protected $table = 'stock_almacen';

    protected $guarded = [];

    public function producto_ids(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public static function ingreso($almacen,$producto,$cantidad){
        $stock_almacen=Stock_almacen::where('almacen_id',$almacen)->where('producto_id',$producto)->first();
        if(empty($stock_almacen)){
            $stock_almacen=new Stock_almacen;
            $stock_almacen->producto_id=$producto;
            $stock_almacen->almacen_id=$almacen;
            $stock_almacen->stock=$cantidad;
        }else{
            $stock_almacen->stock=$stock_almacen->stock+$cantidad;
        }
        $stock_almacen->save();
    }

    public static function egreso($almacen,$producto,$cantidad){
        DB::transaction(function () use ($almacen, $producto, $cantidad) {
            $stock_almacen = Stock_almacen::where('almacen_id', $almacen)
                ->where('producto_id', $producto)
                ->lockForUpdate()
                ->firstOrFail();
            $stock_almacen->stock -= $cantidad;
            $stock_almacen->save();

            self::sincronizarLotesConStock($almacen, $producto, (int) $stock_almacen->stock);
        });
    }

    public static function sincronizarLotesConStock($almacen, $producto, $stockDisponible = null){
        DB::transaction(function () use ($almacen, $producto, $stockDisponible) {
            if ($stockDisponible === null) {
                $stockDisponible = Stock_almacen::where('almacen_id', $almacen)
                    ->where('producto_id', $producto)
                    ->lockForUpdate()
                    ->firstOrFail()
                    ->stock;
            }

            $lotes = Lote::where('almacen_id', $almacen)
                ->where('producto_id', $producto)
                ->orderByRaw('fecha_vencimiento IS NULL, fecha_vencimiento ASC')
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get();

            $pendiente = max(0, (int) $stockDisponible);
            foreach ($lotes->reverse() as $lote) {
                $disponible = min(max(0, (int) $lote->cantidad), $pendiente);
                if ((int) $lote->cantidad_disponible !== $disponible) {
                    $lote->cantidad_disponible = $disponible;
                    $lote->recalcularEstado();
                }
                $pendiente -= $disponible;
            }
        });
    }

    public static function new($producto){
        $stock_almacen_vacio=Stock_almacen::get();
        $productos= Producto::get();
        $almacenes=Almacen::get();

        if(count($stock_almacen_vacio) == 0){
            foreach($almacenes as $almacen){
                foreach($productos as $producto){
                    $stock_almacen=new Stock_almacen;
                    $stock_almacen->producto_id=$producto->id;
                    $stock_almacen->almacen_id=$almacen->id;
                    $stock_almacen->stock=0;
                    $stock_almacen->save();
                }
            }
        }else{
            foreach($almacenes as $almacen){
                $stock_almacen=new Stock_almacen;
                $stock_almacen->producto_id=$producto;
                $stock_almacen->almacen_id=$almacen->id;
                $stock_almacen->stock=0;
                $stock_almacen->save();
            }
        }


    }
}
