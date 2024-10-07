<?php

namespace App\View\Components\ProjectManager;

use App\ProjectManager;
use App\Abstracts\ProjectTableAbstract;
use Illuminate\Pagination\LengthAwarePaginator;

class GanttProjectView extends ProjectTableAbstract {

    /**
     * Create a new component instance.
     *
     * @param LengthAwarePaginator|null $collection
     * @param string|array $type (oneProject, manyProjects) or Array
     * 
     * @return void
     */
    public function __construct(
        string|array $type, // Definido como propiedad pública
        ?LengthAwarePaginator $collection = null,
    ) {
        parent::__construct($collection ?? ProjectManager::paginate(10), $type);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.gantt-project-view', [
            'project_managers' => $this->getCollection(),
            'h_m' => $this->getHeadersAndMethods(),
        ]);
    }
}
