<?php
namespace App\Exports;

use App\Nota_Debito;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class NotaDebitoExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = Nota_Debito::with([
            'nota_i_facturacion',
            'nota_i_boleta',
            'nota_i_fac_manual',
            'nota_i_boleta_manual',
            'nota_i_almacen'
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
            'Código Nota Débito',
            'Facturación',
            'Boleta',
            'Facturación Manual',
            'Boleta Manual',
            'Doc. Cliente',
            'Cliente',
            'Fecha Emisión',
            'Estado',
            'SUNAT',
            'Tipo',
            'Almacén',
            'Operación Gravada',
            'Operación Inafecta',
            'Operación Exonerada',
            'Operación Gratuita',
            'Motivo',
            'IGV',
            'Subtotal',
            'Importe Total'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($nota): array
    {
        $subtotal = ($nota->op_gravada ?? 0)
                  + ($nota->op_inafecta ?? 0)
                  + ($nota->op_exonerada ?? 0);

        $igv = round(($nota->op_gravada ?? 0) * 0.18, 2);

        return [
            $nota->codigo_n_d,
            optional($nota->nota_i_facturacion)->codigo_fac,
            optional($nota->nota_i_boleta)->codigo_boleta,
            optional($nota->nota_i_fac_manual)->codigo_fac,
            optional($nota->nota_i_boleta_manual)->codigo_boleta,
            optional($nota->cliente_obj)->numero_documento,
            optional($nota->cliente_obj)->nombre,
            $nota->fecha_emision,
            $nota->estado == 1 ? 'Activo' : 'Inactivo',
            $nota->n_electronica == 1 ? 'Emitido' : 'Pendiente',
            $nota->tipo,
            optional($nota->nota_i_almacen)->nombre,
            $nota->op_gravada,
            $nota->op_inafecta,
            $nota->op_exonerada,
            $nota->op_gratuita,
            $nota->motivo,
            $igv,
            $subtotal,
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
