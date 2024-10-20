<div class="col-lg-12">
    <div class="mt-3">
        <x-data-table :collection="$data" :headers-and-methods="$h_m" />
        <div class="pagination-wrapper">
            {{ $data->links() }}
        </div>
    </div>
</div>
