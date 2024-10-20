<div class="mt-3" style="display: flex; flex-direction: row;">
    <div class="col-lg-6">
        <x-project-manager.custom-project-table :collection="$activities" :type="$type" />
    </div>
    <div class="col-lg-6" style="overflow-x: scroll;">
        <x-project-manager.gantt-project-table :collection="$activities" />
    </div>
</div>
<div class="ml-3">
    {{ $activities->links() }}
</div>