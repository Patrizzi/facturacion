<?php

namespace App\Exports;

use App\GarantiaInformeTecnico;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class GarantiaInformeTecnicoExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected ?array $ids;
    protected array $filters;

    public function __construct(?array $ids = null, array $filters = [])
    {
        $this->ids = $ids;
        $this->filters = $filters;
    }

    public function query()
    {
        $query = GarantiaInformeTecnico::with([
            'garantia_egreso_i'
        ]);

        // ▶ Exportar por selección
        if (!empty($this->ids)) {
            return $query->whereIn('id', $this->ids)
                         ->orderBy('created_at', 'desc');
        }

        // ▶ Exportar por filtros
        $query->whereBetween('created_at', [
            $this->filters['start'],
            $this->filters['end']
        ])->orderBy('created_at', 'desc');

        // filtro texto (mantengo tu lógica tal cual)
        if (!empty($this->filters['filter'])) {
            $filter = $this->filters['filter'];

            $query->where(function ($q) use ($filter) {
                $q->where('codigo_fac', 'like', "%$filter%")
                  ->orWhereHas('cliente', function ($c) use ($filter) {
                      $c->where('nombre', 'like', "%$filter%")
                        ->orWhere('numero_documento', 'like', "%$filter%");
                  })
                  ->orWhere('fecha_emision', 'like', "%$filter%")
                  ->orWhereHas('forma_pago', function ($fp) use ($filter) {
                      $fp->where('nombre', 'like', "%$filter%");
                  });
            });
        }

        if (!is_null($this->filters['tipo'])) {
            $query->where('tipo', $this->filters['tipo']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Orden de Servicio',
            'Estado',
            'Fecha',
            'Egresado',
            'Informe técnico',
            'Estética',
            'Revisión del diagnóstico',
            'Causas del problema',
            'Solución',
            'Garantía de egresado'
        ];
    }

    public function map($g): array
    {
        $garantiaEgresado = optional($g->garantia_egreso_i)->orden_servicio ?? '';
        $estado = $g->estado == 1 ? 'Activo' : 'Inactivo';

        return [
            $g->orden_servicio,
            $estado,
            $g->fecha,
            $g->egresado,
            $g->informe_tecnico,
            $g->estetica,
            $g->revision_diagnostico,
            $g->causa_del_problema,
            $g->solucion,
            $garantiaEgresado,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach (range('A','Z') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
                foreach (range('A','Z') as $l1) {
                    foreach (range('A','Z') as $l2) {
                        $event->sheet->getColumnDimension($l1.$l2)->setAutoSize(true);
                    }
                }
            }
        ];
    }
}
