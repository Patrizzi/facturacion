<div class="table-responsive">
    <table id={{ $table_id }}
        class="table table-striped table-bordered table-hover dataTables-example dataTable no-footer">
        <tr>
            @if ($hasEnum)
                <th>N</th>
            @endif
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
        @foreach ($collection as $index => $item)
            <tr>
                @if ($hasEnum)
                    <td>{{ $index + 1 }}</td>
                @endif
                @foreach ($lambdas as $method)
                    <td>{{ $method($item) }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
