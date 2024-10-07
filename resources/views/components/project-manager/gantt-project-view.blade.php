<div class="row">
    <div class="col-lg">
        <div id="table-gantt-content" class="ibox-content">
            <div class="table-data">
                <x-project-manager.custom-project-table :collection="$project_managers" :headers-and-methods="$h_m" />
            </div>
            <div class="table-gantt">
                <x-project-manager.gantt-project-table :collection="$project_managers" />
            </div>
        </div>
        <div class="pagination-wrapper">
            {{ $project_managers->links() }}
        </div>
    </div>
</div>
