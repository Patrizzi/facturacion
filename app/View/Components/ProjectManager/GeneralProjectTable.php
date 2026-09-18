<?php

namespace App\View\Components\ProjectManager;

use App\Abstracts\ProjectTableAbstract;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use App\ProjectManager;

class GeneralProjectTable extends ProjectTableAbstract {

    /**
     * Create a new component instance.
     *
     * @param LengthAwarePaginator|null $collection
     */
    public function __construct(?LengthAwarePaginator $collection = null) {

        parent::__construct($collection ?? ProjectManager::paginate(10), 'manyProjects');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.general-project-table', [
            'data' => $this->getCollection(),
            'h_m' => $this->getHeadersAndMethods(),
        ]);
    }
}
