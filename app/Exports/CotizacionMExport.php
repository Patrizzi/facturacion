<?php
namespace App\Exports;

use App\CotizacionManual;
use App\Igv;
use App\RenovacionVentas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class CotizacionMExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = CotizacionManual::with([
            'almacen',
            'cliente',
            'moneda',
            'forma_pago',
            'user_personal.personal',
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
                $q->where('cod_cotizacion', 'like', "%$filter%")
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
            'Código cotizacion',
            'Almacén',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Garantia',
            'Validez',
            'Fecha de emision',
            'Cambio',
            'Observacion',
            'Personal',
            'Estado',
            'Estado vigente',
            'Tipo',
            'Operacion gravada',
            'Operacion inafecta',
            'Operacion Exonerada',
            'Operacion gratuita',
            'Tipo de Operacion',
            'Tipo de Documento',
            'Subtotal',
            'IGV',
            'Importe Total',
            'Tiene Renovación',
            'Fecha Vencimiento',
            'Días Restantes'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($cotizacionM): array
    {
        $subtotal = ($cotizacionM->op_gravada ?? 0)
                  + ($cotizacionM->op_inafecta ?? 0)
                  + ($cotizacionM->op_exonerada ?? 0);

        $igv_val = Igv::first();
        $igv = ($cotizacionM->op_gravada ?? 0) * ($igv_val->igv_total / 100);

        $personal = '';
        if ($cotizacionM->user_personal && $cotizacionM->user_personal->personal) {
            $personal = trim(
                $cotizacionM->user_personal->personal->nombres . ' ' .
                $cotizacionM->user_personal->personal->apellidos
            );
        }

        // VERIFICAR SI TIENE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_manual_id', $cotizacionM->id)
            ->where('estado', 1)
            ->first();

        $tiene_renovacion        = 'No';
        $fecha_vencimiento_texto = '-';
        $dias_restantes_texto    = '-';

        if ($renovacion) {
            $tiene_renovacion  = 'Sí';
            $fecha_actual      = Carbon::now()->startOfDay();
            $fecha_vencimiento = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
            $diff              = $fecha_actual->diffInDays($fecha_vencimiento, false);

            $fecha_vencimiento_texto = $fecha_vencimiento->format('d-m-Y');

            if ($diff < 0) {
                $dias_restantes_texto = abs($diff) . ' días vencido';
            } elseif ($diff == 0) {
                $dias_restantes_texto = 'Vence hoy';
            } elseif ($diff == 1) {
                $dias_restantes_texto = '1 día';
            } else {
                $dias_restantes_texto = $diff . ' días';
            }
        }

        return [
            $cotizacionM->cod_cotizacion,
            optional($cotizacionM->almacen)->nombre,
            optional($cotizacionM->cliente)->nombre,
            optional($cotizacionM->moneda)->nombre,
            optional($cotizacionM->forma_pago)->nombre,
            $cotizacionM->garantia,
            $cotizacionM->validez,
            $cotizacionM->fecha_emision,
            $cotizacionM->cambio,
            $cotizacionM->observacion,
            $personal,
            $cotizacionM->estado ? 'Activo' : 'Inactivo',
            $cotizacionM->estadoVigente ? 'Vigente' : 'No vigente',
            $cotizacionM->tipo,
            number_format(round($cotizacionM->op_gravada,2),2),
            number_format(round($cotizacionM->op_inafecta,2),2),
            number_format(round($cotizacionM->op_exonerada,2),2),
            number_format(round($cotizacionM->op_gratuita,2),2),
            optional($cotizacionM->tipo_operacion)->informacion,
            optional($cotizacionM->tipo_documento)->informacion,
            number_format(round($subtotal,2),2),
            number_format(round($igv, 2),2),
            number_format(round($subtotal + $igv, 2), 2),
            $tiene_renovacion,
            $fecha_vencimiento_texto,
            $dias_restantes_texto
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
