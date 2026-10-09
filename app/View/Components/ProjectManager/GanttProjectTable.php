<?php

namespace App\View\Components\ProjectManager;

use App\Abstracts\ProjectTableAbstract;
use App\ProjectManager;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

require_once app_path('Helpers/ProjectManagerHelper.php');

use function App\Helpers\calculateRangeDate;
use function App\Helpers\calculateWeeks;

class GanttProjectTable extends ProjectTableAbstract {

    public array $weekDays = ['L', 'M', 'Mi', 'J', 'V', 'S', 'D'];
    public Carbon $minDate;
    public Carbon $maxDate;
    public int $totalWeeks;

    /**
     * Create a new component instance.
     *
     * @param LengthAwarePaginator|null $collection
     */
    public function __construct(?LengthAwarePaginator $collection) {
        parent::__construct($collection ?? ProjectManager::paginate(10), 'default');
        $rangeDate = calculateRangeDate($this->collection);
        $this->minDate = $rangeDate['minDate'];
        $this->maxDate = $rangeDate['maxDate'];
        $this->totalWeeks = calculateWeeks($this->minDate, $this->maxDate);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.project-manager.gantt-project-table', [
            'weekDays' => $this->weekDays,
            'collection' => $this->getCollection(),
            'totalWeeks' => $this->totalWeeks,
            'minDate' => $this->minDate,
            'maxDate' => $this->maxDate 
        ]);
    }
}
