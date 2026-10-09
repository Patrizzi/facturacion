<?php
namespace App\Exports;

use App\Facturacion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class FacturasExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected ?array $ids;
    protected array $filters;
    protected array $monedasFila = [];

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
        $query = Facturacion::with([
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
                $q->where('codigo_fac', 'like', "%$filter%")
                  ->orWhereHas('cliente', fn ($c) =>
                      $c->where('nombre', 'like', "%$filter%")
                        ->orWhere('numero_documento', 'like', "%$filter%")
                  )
                  ->orWhere('fecha_emision', 'like', "%$filter%");
            });
        }

        if (!empty($this->filters['estado_pago'])) {
            $query->whereIn('estado_pago', $this->filters['estado_pago']);
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
            'Código Factura',
            'Cotizacion',
            'Almacén',
            'Orden de compra',
            'Guia de Remision',
            'Doc. Cliente',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Fecha de emision',
            'Fecha de vencimiento',
            'Tipo de Cambio',
            'Observacion',
            'Comisionista',
            'Emisor',
            'Vendedor Asignado',
            'Estado',
            'SUNAT',
            'Estado de pago',
            // 'Tipo',
            'Operacion gravada',
            'Operacion inafecta',
            'Operacion Exonerada',
            'Operacion gratuita',
            'Nota Credito',
            'Nota Debito',
            'Tipo de Operacion',
            // 'Tipo de Documento',
            'Subtotal',
            'IGV',
            'Importe Total'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($f): array
    {
        $this->monedasFila[] = optional($f->moneda)->codigo;
        $pl = $f->cliente?->vendedor_asignado?->personal?->personal_l;
        $vendedor = $pl ? $pl->nombres . ' ' . $pl->apellidos: '';
        $comi = $f->select_comisionista?->personal?->personal_l;
        $comisionista = $comi ? $comi->nombres . ' ' . $comi->apellidos : '';
        $subtotal = ($f->op_gravada ?? 0)
                  + ($f->op_inafecta ?? 0)
                  + ($f->op_exonerada ?? 0);

        $igv = ($f->op_gravada ?? 0) * 0.18;
        return [
            $f->codigo_fac,
            optional($f->almacen)->nombre,
            $f->orden_compra,
            $f->guia_remision,
            optional($f->cotizacion)->cod_cotizacion,
            optional($f->cliente)->numero_documento,
            optional($f->cliente)->nombre,
            optional($f->moneda)->nombre,
            optional($f->forma_pago)->nombre,
            $f->fecha_emision,
            $f->fecha_vencimiento,
            $f->cambio,
            $f->observacion,
            $comisionista,
            optional($f->user->personal)->nombres.' '.optional($f->user->personal)->apellidos,
            $vendedor,
            $f->estado == 0 ? 'Guardado' : ($f->estado == 1 ? 'Finalizado' : 'Anulado'),
            $f->f_electronica == 0 ? 'Emitido' : ($f->f_electronica == 1 ? 'Enviado' : 'Rechazado' ),
            $f->estado_pago == 0 ? 'Sin pagar' : ($f->estado_pago == 1 ? 'Pagado adelantado' : 'Pagado'),
            // $f->tipo,
            $f->op_gravada,
            $f->op_inafecta,
            $f->op_exonerada,
            $f->op_gratuita,
            $f->nota_credito,
            $f->nota_debito,
            optional($f->tipo_operacion)->informacion,
            optional($f->tipo_documento)->informacion,
            round($subtotal,2),
            round($igv,2),
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

                $sheet = $event->sheet->getDelegate();

                // Formato dinámico por fila
                foreach ($this->monedasFila as $index => $moneda) {

                    $fila = $index + 2; // fila 1 = encabezados

                    $formato = strtoupper(trim($moneda)) == 'USD'
                        ? '_-[$$-409]* #,##0.00_-;_-[$$-409]* -#,##0.00_-;_-[$$-409]* "-"??_-;_-@_-'
                        : '_-[$S/]* #,##0.00_-;_-[$S/]* -#,##0.00_-;_-[$S/]* "-"??_-;_-@_-';
                    $sheet->getStyle("t{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                    $sheet->getStyle("U{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("V{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("W{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                    
                    $sheet->getStyle("AB{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("AC{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                    $sheet->getStyle("AD{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                }

                // Autoajuste columnas simples
                foreach (range('A', 'AD') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Autoajuste columnas AA, AD, AC...
                foreach (range('A', 'AD') as $letter1) {
                    foreach (range('A', 'AD') as $letter2) {
                        $sheet->getColumnDimension($letter1 . $letter2)->setAutoSize(true);
                    }
                }
            }
        ];
    }
}