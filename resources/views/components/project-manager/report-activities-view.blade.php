<div class="row justify-content-center mt-4">
    @foreach ($estados as $i => $estado)
        <x-widget-nav
            icon="{{ $estado['icon'] }}"
            span="{{ $estado['text'] }}"
            text="{{ $actividadesPorEstado[$i] }}" />
    @endforeach
</div>
<div class="row m-5">
    <div class="col-lg-6" style="overflow-x: scroll;">
        <x-project-manager.gantt-project-table :collection="$pagActivities"/>
    </div>
    <div class="col-lg-6">
        <x-project-manager.pie-chart-activity :data="$pagActivities" />
    </div>
</div>
<div class="ml-3">
    {{ $pagActivities->links() }}
</div>