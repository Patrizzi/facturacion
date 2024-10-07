<?php

namespace App\View\Components\ProjectManager;

use App\Abstracts\ProjectTableAbstract;
use App\ProjectManager;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomProjectTable extends ProjectTableAbstract {

    /**
     * Create a new component instance.
     *
     * @param LengthAwarePaginator|null $collection
     * 
     * @return void
     */
    public function __construct(?LengthAwarePaginator $collection = null, string|array $headersAndMethods) {
        parent::__construct($collection ?? ProjectManager::paginate(10), $headersAndMethods);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.custom-project-table', [
            'collection' => $this->getCollection(),
            'h_m' => $this->getHeadersAndMethods(),
        ]);
    }
}
