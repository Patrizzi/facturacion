<?php

namespace App\View\Components\ProjectManager;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;
use App\Activity;

class ReportActivitiesView extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public LengthAwarePaginator $pagActivities, public $allActivities = null) {
        $this->estados = Activity::getStatuses('text', 'icon');
        $this->actividadesPorEstado = [];
        $project_manager = $pagActivities->first()->project_manager;

        foreach ($this->estados as $key => $estado) {
            $this->actividadesPorEstado[$key] = Activity::where('estado', $key)
            ->where('proyecto_id', $project_manager->id)
            ->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.report-activities-view', [
            "pagActivities" => $this->pagActivities,
            "allActivities" => $this->allActivities,
            "estados" => $this->estados,
            "actividadesPorEstado" => $this->actividadesPorEstado,
        ]);
    }
}
