<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Producto;
use App\Services\LoteSyncService;
use Illuminate\Console\Command;

class SincronizarLotesStock extends Command
{
    protected $signature = 'lotes:sincronizar {--producto= : ID específico de producto a sincronizar}';

    protected $description = 'Sincroniza entradas de kardex y stock de almacén con lotes y series de productos.';

    public function handle(): int
    {
        $productoId = $this->option('producto');

        if ($productoId) {
            $producto = Producto::find($productoId);
            if (!$producto) {
                $this->error("Producto con ID {$productoId} no encontrado.");
                return self::FAILURE;
            }

            $this->info("Sincronizando lotes y series para el producto: {$producto->codigo_producto} - {$producto->nombre}...");
            LoteSyncService::asegurarLotesParaProducto($producto);
            $this->info("Producto sincronizado con éxito.");
            return self::SUCCESS;
        }

        $this->info("Iniciando sincronización completa de lotes y series...");
        $resultado = LoteSyncService::sincronizarTodo();

        $this->info(sprintf(
            "Sincronización completada: %d lotes de kardex, %d lotes iniciales y %d series creadas.",
            $resultado['lotes_kardex'],
            $resultado['lotes_iniciales'],
            $resultado['series_creadas']
        ));

        return self::SUCCESS;
    }
}
