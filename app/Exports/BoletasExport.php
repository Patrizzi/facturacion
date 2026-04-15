<?php
namespace App\Exports;

use App\Boleta;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class BoletasExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = Boleta::with([
            'almacen',
            'cotizacion',
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
                $q->where('codigo_boleta', 'like', "%$filter%")
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
            'Código Boleta',
            'Almacén',
            'Orden de compra',
            'Guia de Remision',
            'Cotizacion',
            'Doc. Cliente',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Fecha de emision',
            'Fecha de vencimiento',
            'Cambio',
            'Observacion',
            'Comisionista',
            'Personal',
            'Estado',
            'SUNAT',
            'Estado de pago',
            'Tipo',
            'Operacion gravada',
            'Operacion inafecta',
            'Operacion Exonerada',
            'Operacion gratuita',
            'Nota Credito',
            'Nota Debito',
            'Tipo de Operacion',
            'Tipo de Documento',
            'Subtotal',
            'IGV',
            'Importe Total'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($b): array
    {
        $subtotal = ($b->op_gravada ?? 0)
                  + ($b->op_inafecta ?? 0)
                  + ($b->op_exonerada ?? 0);

        $igv = round(($b->op_gravada ?? 0) * 0.18, 2);

        return [
            $b->codigo_boleta,
            optional($b->almacen)->nombre,
            $b->orden_compra,
            $b->guia_remision,
            optional($b->cotizacion)->cod_cotizacion,
            optional($b->cliente)->numero_documento,
            optional($b->cliente)->nombre,
            optional($b->moneda)->nombre,
            optional($b->forma_pago)->nombre,
            $b->fecha_emision,
            $b->fecha_vencimiento,
            $b->cambio,
            $b->observacion,
            $b->comisionista,
            optional($b->user->personal)->nombres.' '.optional($b->user->personal)->apellidos,
            $b->estado ? 'Activo' : 'Inactivo',
            $b->f_electronica ? 'Emitido' : 'Pendiente',
            $b->estado_pago == 0 ? 'Sin pagar' : ($b->estado_pago == 1 ? 'Pagado adelantado' : 'Pagado'),
            $b->tipo,
            $b->op_gravada,
            $b->op_inafecta,
            $b->op_exonerada,
            $b->op_gratuita,
            $b->nota_credito,
            $b->nota_debito,
            optional($b->tipo_operacion)->informacion,
            optional($b->tipo_documento)->informacion,
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