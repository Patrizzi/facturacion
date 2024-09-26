<div class="p-card" id="p-card-{{$card->id}}" style="background-color: {{$card->color}}">
    <div class="p-card-title">{{ $titulo }}</div>
    <div class="p-card-content">
        <div class="p-card-header">
            <img src="{{ getImageUrl($card->responsable->avatar, 1) }}" class="p-card-worker-image" alt="worker image">
            <div class="p-card-worker-info">
                <div class="p-card-worker-name">{{ $responsable }}</div>
                <div class="p-card-worker-time">{{createdTime($card)}}</div>
            </div>
            <div class="p-card-action-icons">
                <a href="#" class="fa fa-plus"></a>
                @if($card->responsable_id == auth()->id())
                    <a href="#" class="fa fa-trash" method="delete"></a>
                    <a href="#" class="fa fa-edit"></a>
                @endif
            </div>
        </div>
        <div class="p-card-text">
            <p class="truncate-text" truncate="120">
                {{$card->contenido}}
            </p>
        </div>
        @if ($card->foto) 
            <img src="{{ getImageUrl($card->foto, 2) }}" class="p-card-image" alt="card image">
        @endif
        <div class="p-card-footer">
            <div class="progress-container">
                <div class="progress-bar-date">{{ $fecha_inicio }}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar-border">
                        <div class="progress-bar" style="background-color: #94f261; width: {{ $barra_progreso }}%;"></div>
                    </div>
                </div>
                <div class="progress-bar-text">{{ $barra_progreso }}%</div>
            </div>
        </div>
    </div>
    <!-- Contenedor para los Tasks -->
    @if ($card->tasks->isNotEmpty())
    <div class="p-card-tasks-container" id="tasks-container-{{$card->id}}">
        @foreach ($card->tasks as $task)
            <x-ProjectManager.Activity.Task :task="$task"/>
        @endforeach
    </div>
    @endif
</div>

<style>
.p-card {
    flex: 0 0 auto;
    width: 300px;
    border-radius: 8px;
    padding: 11px;
    margin-bottom: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: black;
}
.p-card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
    margin-left: 10px;
}
.p-card-content {
    background-color: #ffffff;
    border-radius: 5px;
    padding: 10px 0px 8px 0px;
    color: #333;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.p-card-text {
    margin: 5px 10px 5px 10px;
    font-size: 12px;
}
.p-card-image {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
}
.p-card-header {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin: 0px 10px 0px 10px;
    position: relative;
}
.p-card-footer {
    margin: 0px 10px 0px 10px;
}
.p-card-worker-image {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 5px;
    margin-left: 0px;
}
.p-card-worker-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    font-size: 12px;
    flex-grow: 1;
    max-width: calc(60%);
}
.p-card-worker-name {
    font-weight: bold;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.p-card-worker-time {
    color: gray;
    font-size: 10px;
}
.p-card-action-icons {
    display: flex;
    align-items: center;
    gap: 10px;
    position: absolute;
    top: 1px;
    right: 1px;
    font-size: 14px;
}
.progress-container {
    font-size: 1px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 1px;
    font-size: 15px;
}
.progress-bar-date {
    font-size: 10px;
    margin-left: 0px;
    margin-right: 0px;
    color: gray;
}
.progress-bar-container {
    flex: 1;
    margin: 0 0px;
}
.progress-bar-border {
    background-color: #f3f3f3;
    height: 6px;
    border-radius: 5px;
    position: relative;
    /* border: 1px solid #9e9e9e; */
}
.progress-bar {
    height: 100%;
    border-radius: 5px;
}
.progress-bar-text {
    font-size: 10px;
    margin-left: 0px;
    margin-right: 0px;
    color: gray;
}
.p-card-tasks-container {
    max-height: 230px;
    overflow-y: auto;
    scrollbar-width: none;
    border-radius: 8px;
    margin-top: 8px;
}
</style>
