<?php

namespace App\View\Components\ProjectManager;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use App\ProjectManager;

class Table extends Component {

    public array $header_and_methods;
    public LengthAwarePaginator $data;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public int $paginate = 10) {

        $this->data = ProjectManager::paginate($paginate);

        $this->header_and_methods = [
            'Nombre' => function ($item) {
                return $item->nombre;
            },
            'Centro de Costo' => function ($item) {
                return $item->centro_costo;
            },
            'Responsable' => function ($item) {
                return $item->responsable->name;
            },
            'Cliente' => function ($item) {
                return $item->cliente->nombre;
            },
            'Administrador' => function ($item) {
                return $item->administrador->name;
            },
            'Servicio' => function ($item) {
                return $item->project_service->nombre;
            },
            'Fecha Inicio' => function ($item) {
                return $item->fecha_inicio->format('d-m-Y');
            },
            'Fecha Cierre' => function ($item) {
                return $item->fecha_cierre->format('d-m-Y');
            }
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.table', [
            'data' => $this->data,
            'h_m' => $this->header_and_methods,
        ]);
    }
}
