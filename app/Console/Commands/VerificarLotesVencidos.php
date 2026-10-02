<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Lote;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerificarLotesVencidos extends Command
{
    protected $signature = 'lotes:verificar-vencidos';

    protected $description = 'Marca como vencidos los lotes cuya fecha de vencimiento ya pasó.';

    public function handle(): int
    {
        $idsAfectados = [];
        $cantidadActualizada = 0;

        try {
            Lote::query()
                ->where('fecha_vencimiento', '<', Carbon::today()->toDateString())
                ->where('estado', '!=', 'Vencido')
                ->chunkById(100, function ($lotes) use (&$idsAfectados, &$cantidadActualizada) {
                    foreach ($lotes as $lote) {
                        $lote->update(['estado' => 'Vencido']);
                        $idsAfectados[] = $lote->id;
                        $cantidadActualizada++;
                    }
                }, 'id');

            Log::info('Verificación de lotes vencidos ejecutada.', [
                'cantidad_actualizada' => $cantidadActualizada,
                'ids_afectados' => $idsAfectados,
                'fecha' => Carbon::now()->toDateTimeString(),
            ]);

            $this->info(sprintf('Se actualizaron %d lotes vencidos.', $cantidadActualizada));

            return self::SUCCESS;
        } catch (\Throwable $exception) {
            Log::error('Error al verificar lotes vencidos.', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            $this->error('Error: ' . $exception->getMessage());

            return self::FAILURE;
        }
    }
}
