<div class="p-card" id="p-card-{{$card->id}}" style="background-color: {{$card->color}}">
    <div class="p-card-title">{{Str::ucfirst($card->nombre)}}</div>
    <div class="p-card-content">
        <div class="p-card-header">
            <img src="{{ isset($card->responsable->avatar) ? asset('/profile/images/') . '/' . $card->responsable->avatar : 'https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png' }}" class="worker-image" alt="worker image">
            <div class="worker-info">
                <div class="worker-name">{{ Str::ucfirst($card->responsable->nombre ?? $card->responsable->name) }}</div>
                <div class="worker-time">{{createdTime($card)}}</div>
            </div>
            <div class="p-card-action-icons">
                <a href="#" class="fa fa-plus"></a>
                @if($card->responsable_id == auth()->id())
                    <a href="#" class="fa fa-trash" , method: :delete, data: { confirm: 'Estás seguro?' }></a>
                    <a href="#" class="fa fa-edit"></a>
                @endif
            </div>
        </div>
        <div class="p-card-text">
            <p class="truncate-text" truncate="120">
                {{$card->contenido}}
            </p>
        </div>
        @if ($card->foto) <img src="{{ $card->foto }}" class="p-card-image" alt="p-card image"> @endif
        <div class="p-card-footer">
            <div class="progress-container">
                <div class="progress-bar-date">{{$card->fecha_inicio->format('d/m/Y')}}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar-border">
                        <div class="progress-bar" style="background-color: #94f261;  width: {{progressDate($card->fecha_inicio, $card->fecha_cierre)}}%;"></div>
                    </div>
                </div>
                <div class="progress-bar-text">{{progressDate($card->fecha_inicio, $card->fecha_cierre)}}%</div>
            </div>
        </div>
    </div>
    <!-- Contenedor para los Tasks> -->
    @if ($card->tasks->isNotEmpty())
    <div class="tasks-container" id="tasks-container-{{$card->id}}">
        @foreach ($card->tasks as $task)
            <x-project_managers.activity.task :card="$card" :task="$task"/>
        @endforeach
    </div>
    @endif
</div>