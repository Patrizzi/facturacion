<?php

namespace App\View\Components\ProjectManager;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class GanttActivitiesView extends Component {
    /**
     * Create a new component instance.
     *
     * @param LengthAwarePaginator|null $collection
     * @param string|array $type (oneProject, manyProjects) or Array
     * 
     * @return void
     */
    public function __construct(
        public string|array $type, // Definido como propiedad pública
        public ?LengthAwarePaginator $collection = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.gantt-activities-view', [
            'activities' => $this->collection
        ]);
    }
}
