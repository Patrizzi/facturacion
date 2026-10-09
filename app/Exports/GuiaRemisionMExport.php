<?php
namespace App\Exports;

use App\GuiaRemisionManual;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class GuiaRemisionMExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $query = GuiaRemisionManual::with([
            'cliente',
            'vehiculo',
            'personal'
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
                $q->where('cod_guia', 'like', "%$filter%")
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
            'Código',
            'Cliente',
            'Documento',
            'Sucursal cliente',
            'Cód. postal',
            'Fecha emisión',
            'Fecha entrega',
            'Tipo transporte',
            'Vehículo público',
            'Vehículo (placa)',
            'Conductor',
            'Motivo traslado',
            'Observación',
            'SUNAT',
            'Estado',
            'Ticket'
        ];
    }

    /**
     * MAPEO DE CADA FILA
     */
    public function map($gr): array
    {
        $tipoTransporte = [
            0 => 'Sin transporte',
            1 => 'Transporte público',
            2 => 'Transporte privado',
        ][$gr->tipo_transporte] ?? $gr->tipo_transporte;

        $conductorNombre = trim(
            (optional($gr->personal)->nombres ?? '') . ' ' .
            (optional($gr->personal)->apellidos ?? '')
        );
        $conductorNombre = $conductorNombre !== '' ? $conductorNombre : null;

        return [
            $gr->cod_guia,
            optional($gr->cliente)->nombre,
            optional($gr->cliente)->numero_documento,
            $gr->sucursal_cliente,
            $gr->cod_postal_cliente,
            $gr->fecha_emision,
            $gr->fecha_entrega,
            $tipoTransporte,
            $gr->vehiculo_publico,
            optional($gr->vehiculo)->placa,
            $conductorNombre,
            $gr->motivo_traslado,
            $gr->observacion,
            $gr->g_electronica ? 'Enviado' : 'Sin enviar',
            $gr->estado_anulado ? 'Anulado' : 'Activo',
            $gr->ticket_guia_remision_sunat,
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
