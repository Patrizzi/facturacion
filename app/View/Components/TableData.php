<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TableData extends Component {
    public string $table_id = "";
    public array $headers;
    public array $lambdas;
    /**
     * Create a new component instance.
     *
     * @param Collection $collection
     * @param array<string, Closure> $headersAndMethods
     * @param bool $hasEnum
     * @return void
     */
    public function __construct(
        public Collection $collection,
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
        return view('components.table-data');
    }
}
