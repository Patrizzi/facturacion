<?php

namespace App\View\Components\ProjectManager;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class PieChartActivity extends Component {

    private array $activities = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public LengthAwarePaginator $data) {
        $this->activities = [
            'labels' => $data->getCollection()->map(function ($collection) {
                return $collection->nombre;
            }),
            'values' => $data->getCollection()->map(function ($collection) {
                return $collection->percentage();
            }),
            'colors' => $data->getCollection()->map(function ($collection) {
                return $collection->color;
            })
        ];;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.pie-chart', [
            'data' => $this->activities,
            'title' => "Actividades",
        ]);
    }
}
