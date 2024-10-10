<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PieChart extends Component {

    /**
     * Component of pie graphic
     * @param array $data json
     * @param string $title
     */
    public function __construct(public ?array $data = null, public string $title = 'Pie Graphic') {
        $this->data = $data ?? $this->defaultData();
    }

    public function defaultData(): array {
        return [
            'labels' => ['App', 'Software', 'Laptop'],
            'values' => [300, 50, 100],
            'colors' => generateColors(3, 'randomPastelColor'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.pie-chart', [
            'data' => $this->data,
            'title' => $this->title,
        ]);
    }
}
