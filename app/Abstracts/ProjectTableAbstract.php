<?php

namespace App\Abstracts;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class ProjectTableAbstract extends Component {

    protected array $headersAndMethods;

    public function __construct(
        protected LengthAwarePaginator $collection,
        array|string|null $headersAndMethods = null
    ) {
        $this->headersAndMethods = static::processHeadersAndMethods($headersAndMethods);
    }

    public function getCollection(): LengthAwarePaginator {
        return $this->collection;
    }

    public function getHeadersAndMethods(): array {
        return $this->headersAndMethods;
    }

    protected static function getDefaults() {
        return [
            'default' => [],
            'oneProject' => [
                'Proyecto' => function ($item) {
                    return $item->nombre;
                },
                'Cliente' => function ($item) {
                    return $item->cliente ? $item->cliente->nombre : "Sin cliente";
                },
                'R.U.C.' => function ($item) {
                    return $item->ruc;
                },
                'Servicio' => function ($item) {
                    return optional($item->servicio)->nombre ?? 'N/A';
                }
            ],
            'manyProjects' => [
                'Nombre' => function ($item) {
                    $showLink=html()->a($item->nombre)->text($item->nombre)->href(route('project_managers.show',$item->id))->class('text-primary p-1');
                    $editLink=html()->a($item->nombre)->href(route('project_managers.edit',$item->id))->class('fa fa-edit text-primary');
                    $deletebutton= html()->modelForm($item,'DELETE',route('project_managers.destroy',$item->id))->class('d-inline')
                    ->children(html()->submit('')->class('fa fa-trash btn-link border-0 p-0 m-1'))->children(html()->closeModelForm());
                    $desvincular=html()->button()->class('p-0 border-0');
                    return html()->label($showLink ." ". $editLink .$desvincular.$deletebutton);
                },
                'Centro de Costo' => function ($item) {
                    return $item->centro_costo;
                },
                'Responsable' => function ($item) {
                    return $item->responsable->name;
                },
                'Cliente' => function ($item) {
                    return $item->cliente ? $item->cliente->nombre : "Sin cliente"; // clientes sin nombre
                },
                'Administrador' => function ($item) {
                    return $item->administrador->name;
                },
                'Servicio' => function ($item) {
                    return optional($item->servicio)->nombre ?? 'N/A';
                },
                'Fecha Inicio' => function ($item) {
                    return $item->fecha_inicio->format('d-m-Y');
                },
                'Fecha Cierre' => function ($item) {
                    return $item->fecha_cierre->format('d-m-Y');
                }
            ],
            'manyActivities' => [
                "Actividad" => function ($item) {
                    return $item->nombre;
                },
                "F.I." => function ($item) {
                    return $item->fecha_inicio;
                },
                "F.T." => function ($item) {
                    return $item->fecha_cierre;
                },
                "Reponsable" => function ($item) {
                    return $item->responsable->name;
                },
                "Estado" => function ($item) {
                    return $item->getStatus();
                }
            ]
        ];
    }

    protected static function processHeadersAndMethods(array|string|null $h_m): array {

        $default = static::getDefaults();

        if (is_array($h_m) && !empty($h_m)) {
            return $h_m;
        }

        if (is_string($h_m)) {
            if (array_key_exists($h_m, $default)) {
                return $default[$h_m];
            } else {
                throw new \Exception("La clave '$h_m' no existe en el array default (" . join(', ', array_keys($default)) . ").");
            }
        }

        throw new \Exception("El valor de headersAndMethods debe ser una cadena (" . join(', ', array_keys($default)) . ") o un array valido.");
    }
}
