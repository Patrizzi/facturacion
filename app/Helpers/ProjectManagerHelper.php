<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

function calculateRangeDate(LengthAwarePaginator $collection): array {
    $initDate = Carbon::parse($collection->min('fecha_inicio'));
    $endDate = Carbon::parse($collection->max('fecha_final'));

    return ['minDate' => $initDate, 'maxDate' => $endDate];
}


function calculateWeeks(Carbon $date1, Carbon $date2): int {
    if (is_null($date1) || is_null($date2)) {
        return 0;
    }

    $total_days = $date2->diffInDays($date1);
    $total_weeks = ceil($total_days / 7) + 1;
    return $total_weeks;
}

function calculateDays(Carbon $date1, Carbon $date2): int {
    $total_days = $date2->diffInDays($date1) + 1;
    return $total_days;
}
