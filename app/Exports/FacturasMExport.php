<?php
namespace App\Exports;

use App\Facturacion_m;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class FacturasMExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = Facturacion_m::with([
            'cotizacionM',
            'almacen',
            'cliente',
            'moneda',
            'forma_pago',
            'user.personal',
            'tipo_operacion',
            'tipo_documento'
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
            'Código Factura Manual',
            'Cotización',
            'Almacén',
            'Orden de compra',
            'Guía de remisión',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Fecha de emisión',
            'Fecha de vencimiento',
            'Tipo de cambio',
            'Observación',
            'Personal',
            'Estado',
            'SUNAT',
            'Estado de pago',
            'Operación gravada',
            'Operación inafecta',
            'Operación exonerada',
            'Operación gratuita',
            'Nota crédito',
            'Nota débito',
            'Tipo de operación',
            'Tipo de documento',
            'Subtotal',
            'IGV',
            'Importe total'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($f): array
    {
        $subtotal = ($f->op_gravada ?? 0)
                  + ($f->op_inafecta ?? 0)
                  + ($f->op_exonerada ?? 0);

        $igv = round(($f->op_gravada ?? 0) * 0.18, 2);

        return [
            $f->codigo_fac,
            optional($f->cotizacionM)->cod_cotizacion,
            optional($f->almacen)->nombre,
            $f->orden_compra,
            $f->guia_remision,
            optional($f->cliente)->nombre,
            optional($f->moneda)->nombre,
            optional($f->forma_pago)->nombre,
            $f->fecha_emision,
            $f->fecha_vencimiento,
            $f->cambio,
            $f->observacion,
            optional($f->user->personal)->nombres.' '.optional($f->user->personal)->apellidos,
            $f->estado ? 'Activo' : 'Inactivo',
            $f->f_electronica ? 'Emitido' : 'Pendiente',
            $f->estado_pago == 0 ? 'Sin pagar' : ($f->estado_pago == 1 ? 'Pagado adelantado' : 'Pagado'),
            $f->op_gravada,
            $f->op_inafecta,
            $f->op_exonerada,
            $f->op_gratuita,
            $f->nota_credito,
            $f->nota_debito,
            optional($f->tipo_operacion)->informacion,
            optional($f->tipo_documento)->informacion,
            $subtotal,
            $igv,
            round($subtotal + $igv, 2),
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
