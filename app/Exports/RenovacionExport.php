<?php
namespace App\Exports;

use App\RenovacionVentas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class RenovacionExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function query()
    {
        return RenovacionVentas::with([
            'cotizacionManual.almacen',
            'cotizacionManual.cliente',
            'cotizacionManual.moneda',
            'cotizacionManual.forma_pago',
            'cotizacionManual.user_personal.personal',
            'cotizacionManual.tipo_operacion',
            'cotizacionManual.tipo_documento',
            'cotizacion.almacen',
            'cotizacion.cliente',
            'cotizacion.moneda',
            'cotizacion.forma_pago',
            'cotizacion.user_personal.personal',
            'cotizacion.tipo_operacion',
            'cotizacion.tipo_documento',
        ])
        ->whereIn('id', $this->ids)
        ->orderBy('created_at', 'desc');
    }

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
            'Días Restantes',
        ];
    }

    public function map($renovacion): array
    {
        $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;

        if (!$cotizacion) {
            return array_fill(0, count($this->headings()), '-');
        }

        $personal = '';
        if ($cotizacion->user_personal && $cotizacion->user_personal->personal) {
            $personal = trim(
                $cotizacion->user_personal->personal->nombres . ' ' .
                $cotizacion->user_personal->personal->apellidos
            );
        }

        $subtotal     = ($cotizacion->op_gravada ?? 0)
                      + ($cotizacion->op_inafecta ?? 0)
                      + ($cotizacion->op_exonerada ?? 0);
        $igv          = round(($cotizacion->op_gravada ?? 0) * 0.18, 2);
        $importeTotal = round($subtotal + $igv, 2);

        $fecha_vencimiento_texto = '-';
        $dias_restantes_texto    = '-';

        if ($renovacion->fecha_vencimiento) {
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
            $cotizacion->cod_cotizacion,
            optional($cotizacion->almacen)->nombre,
            optional($cotizacion->cliente)->nombre,
            optional($cotizacion->moneda)->nombre,
            optional($cotizacion->forma_pago)->nombre,
            $cotizacion->garantia,
            $cotizacion->validez,
            $cotizacion->fecha_emision,
            $cotizacion->cambio,
            $cotizacion->observacion,
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
            $importeTotal,
            'Sí',
            $fecha_vencimiento_texto,
            $dias_restantes_texto,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach (range('A', 'Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
                foreach (range('A', 'Z') as $l1) {
                    foreach (range('A', 'Z') as $l2) {
                        $event->sheet->getColumnDimension($l1 . $l2)->setAutoSize(true);
                    }
                }
            },
        ];
    }
}