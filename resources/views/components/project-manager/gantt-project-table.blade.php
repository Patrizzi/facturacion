<table id="table-gantt">
    <thead>
        <tr>
            @for ($i = 0; $i < $totalWeeks; $i++)
                <th colspan="7">Semana {{ $i + 1 }}</th>
            @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $totalWeeks; $i++)
                @foreach ($weekDays as $day)
                    <th>{{ $day }}</th>
                @endforeach
            @endfor
        </tr>
    </thead>
    <tbody class="ibox-content">
        @foreach ($collection as $pm)
            <tr id="row-gantt-{{ $pm->id }}">
                <td colspan="{{ $pm->daysToStart($minDate) }}"> </td>
                <td colspan="{{ $pm->diffDays() }}">
                    <div class="progress progress-mini">
                        <div class="progress-bar" style="width: {{ $pm->percentage() }}%;"></div>
                    </div>
                </td>
                <td colspan="999"> </td>
            </tr>
        @endforeach
    </tbody>
</table>
