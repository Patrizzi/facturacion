<?php

namespace App\Exports;

use App\GarantiaGuiaEgreso;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class GarantiaGEgresoExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected ?array $ids;
    protected array $filters;

    // Recibe un array de IDs o filtros para la consulta
    public function __construct(?array $ids = null, array $filters = [])
    {
        $this->ids = $ids;
        $this->filters = $filters;
    }

    // Construye la consulta según los IDs o filtros proporcionados
    public function query()
    {
        $query = GarantiaGuiaEgreso::with([
            'garantia_ingreso_i.marcas_i',
            'garantia_ingreso_i.clientes_i'
        ]);

        if (!empty($this->ids)) {
            return $query->whereIn('id', $this->ids)
                         ->orderBy('created_at', 'desc');
        }

        $query->whereBetween('created_at', [
            $this->filters['start'],
            $this->filters['end']
        ])->orderBy('created_at', 'desc');

        // filtro texto
        if (!empty($this->filters['filter'])) {
            $filter = $this->filters['filter'];

            $query->whereHas('garantia_ingreso_i', function ($sub) use ($filter) {
                $sub->where(function ($q) use ($filter) {
                    $q->where('orden_servicio', 'like', "%$filter%")
                      ->orWhere('motivo', 'like', "%$filter%")
                      ->orWhere('asunto', 'like', "%$filter%")
                      ->orWhereHas('clientes_i', function ($q2) use ($filter) {
                          $q2->where('nombre', 'like', "%$filter%");
                      })
                      ->orWhereHas('marcas_i', function ($q3) use ($filter) {
                          $q3->where('nombre', 'like', "%$filter%");
                      });
                });
            });
        }

        if (!empty($this->filters['marca'])) {
            $marca = $this->filters['marca'];

            $query->whereHas('garantia_ingreso_i', function ($q) use ($marca) {
                $q->where('marca_id', $marca);
            });
        }

        return $query;
    }

    // Define los encabezados de las columnas en el Excel
    public function headings(): array
    {
        return [
            'Fecha', 'Orden de Servicio', 'Estado', 'Egresado', 'Informe técnico',
            'Descripcion del problema', 'Solucion', 'Recomendaciones', 'Garantia Ingreso'
        ];
    }

    // Mapea cada registro a una fila del Excel, formateando los datos según sea necesario
    public function map($e): array
    {
        $estado = $e->estado == 0 ? 'Anulado' : 'No anulado';
        $egresado = $e->egresado ? 'Si' : 'No';
        $informeTecnico = $e->informe_tecnico ? 'Si' : 'No';
        $garantiaIngreso = optional($e->garantia_ingreso_i)->orden_servicio;

        return [
            $e->fecha,
            $e->orden_servicio,
            $estado,
            $egresado,
            $informeTecnico,
            $e->descripcion_problema,
            $e->diagnostico_solucion,
            $e->recomendaciones,
            $garantiaIngreso
        ];
    }

    // Ajusta el ancho de las columnas automáticamente después de generar la hoja
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
