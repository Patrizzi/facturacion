<div class="mt-3" style="display: flex; flex-direction: row;">
    <div class="col-lg-6">
        <x-project-manager.custom-project-table :collection="$project_managers" :headers-and-methods="$h_m" />
    </div>
    <div class="col-lg-6" style="overflow-x: scroll;">
        <x-project-manager.gantt-project-table :collection="$project_managers" />
    </div>
</div>
<div class="ml-3">
    {{ $project_managers->links() }}
</div>
