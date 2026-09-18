<?php

namespace App\Exports;

use App\GarantiaGuiaIngreso;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class GarantiaGIngresoExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = GarantiaGuiaIngreso::with([
            'marcas_i',
            'personal_laborales',
            'clientes_i',
            'contactos'
        ]);

        if (!empty($this->ids)) {
            return $query
                ->whereIn('id', $this->ids)
                ->orderBy('created_at', 'desc');
        }

        $query->whereBetween('created_at', [
            $this->filters['start'],
            $this->filters['end']
        ])->orderBy('created_at', 'desc');

        if (!empty($this->filters['filter'])) {
            $filter = $this->filters['filter'];
            $query->where(function ($q) use ($filter) {
                $q->where('orden_servicio', 'like', "%$filter%")
                    ->orWhere('motivo', 'like', "%$filter%")
                    ->orWhereHas('clientes_i', function ($q) use ($filter) {
                        $q->where('nombre', 'like', "%$filter%");
                    })
                    ->orWhereHas('marcas_i', function ($q) use ($filter) {
                        $q->where('nombre', 'like', "%$filter%");
                    });
            });
        }

        if (!empty($this->filters['marca'])) {
            $query->where('marca_id', $this->filters['marca']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Motivo',
            'Fecha',
            'Orden de Servicio',
            'Estado',
            'Egresado',
            'Asunto',
            'Nombre del equipo',
            'Numero de serie',
            'Codigo interno',
            'Fecha de compra',
            'Descripcion del problema',
            'Revision del diagnostico',
            'Estetica',
            'Marca',
            'Personal laboral',
            'Cliente',
            'Contacto del cliente'
        ];
    }

    public function map($g): array
    {
        $estado = $g->estado == 0 ? 'Anulado' : 'No anulado';
        $egresado = $g->egresado ? 'Si' : 'No';

        $marca = optional($g->marcas_i)->nombre;

        $personalLab = '';
        if ($g->personal_laborales) {
            $personalLab = trim($g->personal_laborales->nombres . ' ' . $g->personal_laborales->apellidos);
        }

        $cliente = optional($g->clientes_i)->nombre;
        $contacto = optional($g->contactos)->nombre;

        return [
            $g->motivo,
            $g->fecha,
            $g->orden_servicio,
            $estado,
            $egresado,
            $g->asunto,
            $g->nombre_equipo,
            $g->numero_serie,
            $g->codigo_interno,
            $g->fecha_compra,
            $g->descripcion_problema,
            $g->revision_diagnostico,
            $g->estetica,
            $marca,
            $personalLab,
            $cliente,
            $contacto,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach (range('A', 'Z') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                foreach (range('A', 'Z') as $l1) {
                    foreach (range('A', 'Z') as $l2) {
                        $event->sheet->getColumnDimension($l1 . $l2)->setAutoSize(true);
                    }
                }
            }
        ];
    }
}
