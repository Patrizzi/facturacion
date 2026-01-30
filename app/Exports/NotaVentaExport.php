<?php
namespace App\Exports;

use App\NotaVenta;
// use App\RenovacionVentas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class NotaVentaExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected ?array $ids;
    protected array $filters;

    public function __construct(?array $ids = null, array $filters = [])
    {
        $this->ids = $ids;
        $this->filters = $filters;
    }

    /**
     * QUERY PRINCIPAL (STREAMING)
     */
    public function query()
    {
        $query = NotaVenta::with([
            'cliente',
            'almacen',
            'user',
            'moneda',
            'forma_pago'
        ]);

        // ▶ Exportar por selección
        if (!empty($this->ids)) {
            return $query
                ->whereIn('id', $this->ids)
                ->orderBy('created_at', 'desc');
        }

        // ▶ Exportar por filtros
        $query->whereBetween('created_at', [
            $this->filters['start'],
            $this->filters['end']
        ]);

        if (!empty($this->filters['filter'])) {
            $filter = $this->filters['filter'];
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_fac', 'like', "%$filter%")
                  ->orWhereHas('cliente', fn ($c) =>
                      $c->where('nombre', 'like', "%$filter%")
                        ->orWhere('numero_documento', 'like', "%$filter%")
                  )
                  ->orWhereHas('forma_pago', fn ($fp) =>
                      $fp->where('nombre', 'like', "%$filter%")
                  )
                  ->orWhere('fecha_emision', 'like', "%$filter%");
            });
        }

        if (!is_null($this->filters['tipo'])) {
            $query->where('tipo', $this->filters['tipo']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * CABECERAS
     */
    public function headings(): array
    {
        return [
            'Código Nota Venta',
            'Cotización',
            'Cotización Manual',
            'Cliente',
            'Almacén',
            'Forma de Pago',
            'Garantía',
            'Moneda',
            'Fecha Emisión',
            'Observación',
            'Estado Vigente',
            'Estado Pago',
            'Usuario Registrado',
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($nota): array
    {
        // Estado vigente
        $estado_vigente = $nota->estado_vigente == 1 ? 'Vigente' : 'No vigente';

        // Estado de pago
        switch ($nota->estado_pago) {
            case 0:
                $estado_pago = 'Sin pago';
                break;
            case 1:
                $estado_pago = 'Adelantado';
                break;
            case 2:
                $estado_pago = 'Pagado';
                break;
            default:
                $estado_pago = 'Desconocido';
                break;
        }

        return [
            $nota->cod_nota_venta,
            $nota->id_cotizacion,
            $nota->id_cotizacion_m,
            optional($nota->cliente)->nombre,
            optional($nota->almacen)->nombre,
            $nota->forma_pago,
            $nota->garantia,
            optional($nota->moneda)->nombre,
            $nota->fecha_emision,
            $nota->observacion,
            $estado_vigente,
            $estado_pago,
            optional($nota->user)->name,
        ];
    }

    /**
     * FORMATO (opcional)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach (range('A', 'Z') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                foreach(range('A','Z') as $letter1) {
                    foreach(range('A','Z') as $letter2) {
                        $event->sheet->getColumnDimension($letter1.$letter2)->setAutoSize(true);
                    }
                }
            }
        ];
    }
}