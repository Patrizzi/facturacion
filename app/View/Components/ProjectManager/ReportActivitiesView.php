<?php

namespace App\View\Components\ProjectManager;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ReportActivitiesView extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public LengthAwarePaginator $collection) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.report-activities-view', [
            "activities" => $this->collection
        ]);
    }
}
