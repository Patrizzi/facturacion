<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class DataTable extends Component {
    public string $table_id = "";
    public array $headers;
    public array $lambdas;
    /**
     * Create a new component instance.
     *
     * @param LengthAwarePaginator $collection
     * @param array<string, Closure> $headersAndMethods
     * @param bool $hasEnum
     * @return void
     */
    public function __construct(
        public LengthAwarePaginator $collection,
        public array $headersAndMethods = [], 
        public bool $hasEnum = false
    ) {
        $this->headers = array_keys($headersAndMethods);
        $this->lambdas = array_values($headersAndMethods);
        if ($collection->isNotEmpty()) {
            $modelClass = get_class($collection->first());
            $this->table_id = "table-" . strtolower(class_basename($modelClass)) ;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.data-table');
    }
}
