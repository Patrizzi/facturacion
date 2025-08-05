<?php

namespace App\View\Components\ProjectManager;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;
use App\View\Components\PieChart;

class PieChartActivity extends Component {

    private array $activities = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $data) {
        $collection = $data instanceof LengthAwarePaginator ? $data->getCollection() : $data;

        $this->activities = [
            'labels' => $collection->map(function ($item) {
                return $item->nombre;
            }),
            'values' => $collection->map(function ($item) {
                return $item->percentage();
            }),
            'colors' => $collection->map(function ($item) {
                return $item->color;
            })
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return app(PieChart::class, [
            'data' => $this->activities,
            'title' => "Actividades",
        ])->render();
    }
}
