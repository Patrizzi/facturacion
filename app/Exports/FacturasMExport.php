<?php
namespace App\Exports;

use App\Facturacion_m;
use App\Igv;
use App\Nota_Credito;
use App\Nota_Debito;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithColumnFormatting,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FacturasMExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
            'Código Factura Manual',
            'Cotización',
            'Almacén',
            'Orden de compra',
            'Guía de remisión',
            'Doc. Cliente',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Fecha de emisión',
            'Fecha de vencimiento',
            'Tipo de cambio',
            'Observación',
            'Emisor',
            'Vendedor Asignado',
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
            // 'Tipo de documento',
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
        $this->monedasFila[] = optional($f->moneda)->codigo;
        $pl = $f->cliente?->vendedor_asignado?->personal?->personal_l;
        $vendedor = $pl ? $pl->nombres . ' ' . $pl->apellidos: '';

        $subtotal = ($f->op_gravada ?? 0)
                  + ($f->op_inafecta ?? 0)
                  + ($f->op_exonerada ?? 0);
        $igv_val = Igv::first();
        $igv = ($f->op_gravada ?? 0) * ($igv_val->igv_total / 100);

        if($f->nota_credito != 0){
            $nota_cred = Nota_Credito::where('facturacion_m_id', $f->id)->first();
            $codigo_nc = $nota_cred->codigo_n_c;
        }
        if($f->nota_debito != 0){
            $nota_deb = Nota_Debito::where('facturacion_m_id',  $f->id)->first();
            $codigo_nd = $nota_deb->codigo_n_d;
        }
        return [
            $f->codigo_fac,
            optional($f->cotizacionM)->cod_cotizacion,
            optional($f->almacen)->nombre,
            $f->orden_compra,
            $f->guia_remision,
            optional($f->cliente)->numero_documento,
            optional($f->cliente)->nombre,
            optional($f->moneda)->nombre,
            optional($f->forma_pago)->nombre,
            $f->fecha_emision,
            $f->fecha_vencimiento,
            $f->cambio,
            $f->observacion,
            optional($f->user->personal)->nombres.' '.optional($f->user->personal)->apellidos,
            $vendedor,
            $f->estado ? 'Activo' : 'Inactivo',
            $f->f_electronica ? 'Emitido' : 'Pendiente',
            $f->estado_pago == 0 ? 'Sin pagar' : ($f->estado_pago == 1 ? 'Pagado adelantado' : 'Pagado'),
            round($f->op_gravada,2),
            round($f->op_inafecta,2),
            round($f->op_exonerada,2),
            round($f->op_gratuita,2),
            $codigo_nc ?? "",
            $codigo_nd ?? "",
            optional($f->tipo_operacion)->informacion,
            // optional($f->tipo_documento)->informacion,
            round($subtotal, 2),
            round($igv, 2),
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

                    $sheet->getStyle("S{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("T{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("U{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                    
                    $sheet->getStyle("V{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("Z{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);

                    $sheet->getStyle("AA{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                        
                    $sheet->getStyle("AB{$fila}")
                        ->getNumberFormat()
                        ->setFormatCode($formato);
                }

                // Autoajuste columnas simples
                foreach (range('A', 'AB') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Autoajuste columnas AA, AB, AC...
                foreach (range('A', 'AB') as $letter1) {
                    foreach (range('A', 'AB') as $letter2) {
                        $sheet->getColumnDimension($letter1 . $letter2)->setAutoSize(true);
                    }
                }
            }
        ];
    }
}
