<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <x-data-table :collection="$data" :headers-and-methods="$h_m" />
                <div class="pagination-wrapper">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
