@push('css') 
    @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/cards/card.css') }}">
    @endonce
@endpush
<div class="p-card" id="p-card-{{$card->id}}" style="background-color: {{$card->color}}">
    <div class="p-card-title simple-truncate">{{ $titulo }}</div>
    <div class="p-card-content">
        <div class="p-card-header">
            <img src="{{ $responsable_foto }}" class="p-card-worker-image" alt="worker image">
            <div class="p-card-worker-info">
                <div class="p-card-worker-name simple-truncate">{{ $responsable }}</div>
                <div class="p-card-worker-time">{{createdTime($card)}}</div>
            </div>
            <div class="p-card-action-icons">
                <a href="#" class="fa fa-plus" data-toggle="modal" data-target="#dynamicModal" data-url="{{ $url_buttons['create_task'] }}"></a>
                {{-- @if($card->responsable_id == auth()->id()) --}}
                    <a href="#" class="fa fa-trash delete-item" style="cursor: pointer;"></a>
                    <form action="{{ $url_buttons['delete_card'] }}" method="POST" style="display: none;" class="delete-item-form">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a href="#" class="fa fa-edit" data-toggle="modal" data-target="#dynamicModal" data-url="{{ $url_buttons['edit_card'] }}"></a>
                {{-- @endif --}}
            </div>
        </div>
        <div class="p-card-text">
            <p class="truncate-text" truncate="110">
                {{$card->contenido ?: 'Sin contenido'}}
            </p>
        </div>
        @if ($card->foto) 
            <img src="{{ $card_foto }}" class="p-card-image" alt="card image">
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
    @if ($card->tasks->isNotEmpty())
    <div class="p-card-tasks-container" id="tasks-container-{{$card->id}}">
        @foreach ($card->tasks as $task)
            <x-project-manager.activity.task :task="$task"/>
        @endforeach
    </div>
    @endif
</div>