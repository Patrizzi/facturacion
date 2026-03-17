<?php
namespace App\Exports;

use App\Cotizacion;
use App\RenovacionVentas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class CotizacionExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = Cotizacion::with([
            'almacen',
            'cliente',
            'moneda',
            'forma_pago',
            'comisionista',
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
            'Doc. Cliente',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Estado aprobado',
            'Aprobado por',
            'Garantia',
            'Validez',
            'Fecha de emision',
            'Fecha de vencimiento',
            'Cambio',
            'Observacion',
            'Comisionista',
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
            'Frecuencia Renovación',
            'Fecha Vencimiento',
            'Días Restantes'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($cotizacion): array
    {
        $subtotal = ($cotizacion->op_gravada ?? 0)
                  + ($cotizacion->op_inafecta ?? 0)
                  + ($cotizacion->op_exonerada ?? 0);

        $igv = round(($cotizacion->op_gravada ?? 0) * 0.18, 2);

        $personal = '';
        if ($cotizacion->user_personal && $cotizacion->user_personal->personal) {
            $personal = trim(
                $cotizacion->user_personal->personal->nombres . ' ' . 
                $cotizacion->user_personal->personal->apellidos
            );
        }

        // VERIFICAR SI TIENE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_id', $cotizacion->id)
            ->where('estado', 1)
            ->first();

        $tiene_renovacion = 'No';
        $frecuencia_renovacion = '-';
        $fecha_vencimiento_texto = '-';
        $dias_restantes_texto = '-';

        if ($renovacion) {
            $tiene_renovacion = 'Sí';
            $frecuencia_renovacion = $renovacion->frecuencia;

            $fecha_actual = Carbon::now()->startOfDay();
            $fecha_emision = Carbon::parse($cotizacion->fecha_emision)->startOfDay();
            $fecha_vencimiento = null;

            // CALCULAR FECHA DE VENCIMIENTO
            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dia_renovacion = (int) $renovacion->dia_mensual;

                $fecha_vencimiento = Carbon::create(
                    $fecha_emision->year,
                    $fecha_emision->month,
                    min($dia_renovacion, $fecha_emision->daysInMonth)
                )->startOfDay();

                if ($fecha_vencimiento->lt($fecha_emision)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }

            } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                $dia_vencimiento = (int) $renovacion->dia_anual;
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_base = $renovacion->anio_anual ?? $fecha_actual->year;

                try {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, $dia_vencimiento)->startOfDay();
                } catch (\Exception $e) {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, 1)
                        ->endOfMonth()
                        ->startOfDay();
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addYear();
                }
            }

            // CALCULAR DÍAS RESTANTES
            if ($fecha_vencimiento) {
                $fecha_vencimiento_texto = $fecha_vencimiento->format('d-m-Y');
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }
        }

        return [
            $cotizacion->cod_cotizacion,
            optional($cotizacion->almacen)->nombre,
            optional($cotizacion->cliente)->numero_documento,
            optional($cotizacion->cliente)->nombre,
            optional($cotizacion->moneda)->nombre,
            optional($cotizacion->forma_pago)->nombre,
            $cotizacion->estado_aprobado ? 'Si' : 'No',
            $cotizacion->aprobado_por,
            $cotizacion->garantia,
            $cotizacion->validez,
            $cotizacion->fecha_emision,
            $cotizacion->fecha_vencimiento,
            $cotizacion->cambio,
            $cotizacion->observacion,
            optional($cotizacion->comisionista)->cod_vendedor,
            $personal,
            $cotizacion->estado ? 'Activo' : 'Inactivo',
            $cotizacion->estadoVigente ? 'Vigente' : 'No vigente',
            $cotizacion->tipo,
            $cotizacion->op_gravada,
            $cotizacion->op_inafecta,
            $cotizacion->op_exonerada,
            $cotizacion->op_gratuita,
            optional($cotizacion->tipo_operacion)->informacion,
            optional($cotizacion->tipo_documento)->informacion,
            $subtotal,
            $igv,
            round($subtotal + $igv, 2),
            $tiene_renovacion,
            $frecuencia_renovacion,
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