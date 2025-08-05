{!! push_asset_once('css/project_managers/gantt.css') !!}

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
            <tr id="gant-{{ $pm->id }}">
                <td colspan="{{ daysToStart($pm, $minDate) }}"> </td>
                <td colspan="{{ diffDays($pm) }}">
                    <div class="progress progress-mini">
                        <div class="progress-bar" style="width: {{ percentage($pm) }}%;"></div>
                    </div>
                </td>
                <td colspan="999"> </td>
            </tr>
        @endforeach
    </tbody>
</table>
