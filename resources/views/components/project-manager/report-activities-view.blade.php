<div class="row justify-content-center mt-4">
    <x-widget-nav icon="fa-check" span="Avanzado" text="23" />
    <x-widget-nav icon="fa-undo" span="Esperando" text="23" />
    <x-widget-nav icon="fa-times" span="No terminado" text="23" />
</div>
<div class="row m-5">
    <div class="col-lg-6" style="overflow-x: scroll;">
        <x-project-manager.gantt-project-table :collection="$activities" />
    </div>
    <div class="col-lg-6">
        <x-project-manager.pie-chart-activity :data="$activities" />
    </div>
</div>