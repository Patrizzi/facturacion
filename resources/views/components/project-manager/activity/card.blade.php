@push('css')
    @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/cards/card.css') }}">
    @endonce
@endpush
<div class="p-card" id="p-card-{{ $id }}" style="background-color: {{ $color }}">
    <div class="p-card-title simple-truncate">{{ $titulo }}</div>
    <div class="p-card-content">
        @if ( $cardFound() )
            <div class="p-card-header">
                <img src="{{ $responsable_foto }}" class="p-card-worker-image" alt="worker image">
                <div class="p-card-worker-info">
                    <div class="p-card-worker-name simple-truncate">{{ $responsable_nombre }}</div>
                    <div class="p-card-worker-time">{{ $tiempo_transcurrido }}</div>
                </div>
                <div class="p-card-action-icons">
                    <a href="#" class="fa fa-plus" data-toggle="modal" data-target="#formModal"
                        data-url="{{ $url_buttons['create_task'] }}"> {{ $card->tasks()->count() }}</a>
                    @if ($responsable_id == auth()->id())
                        <a href="#" class="fa fa-trash" onclick="deleteItem('{{ $id }}')"></a>
                        <form action="{{ $url_buttons['delete_card'] }}" method="POST" style="display: none;"
                            id="delete-item-form-{{ $id }}">
                            @csrf
                            @method('DELETE')
                        </form>
                        <a href="#" class="fa fa-edit" data-toggle="modal" data-target="#formModal"
                            data-url="{{ $url_buttons['edit_card'] }}"></a>
                    @endif
                </div>
            </div>
        @endif
        <div class="p-card-text">
            <p class="truncate-text" truncate="110">
                {{ $contenido }}
            </p>
        </div>
        @if ($foto || !$cardFound())
            <img src="{{ $foto_url }}" class="p-card-image" alt="card image">
        @endif
        @if ( $cardFound() )
            <div class="p-card-footer">
                <div class="progress-container">
                    <div class="progress-bar-date">{{ $fecha_inicio }}</div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-border">
                            <div class="progress-bar" style="background-color: #94f261; width: {{ $progreso }}%;">
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar-text">{{ $progreso }}%</div>
                </div>
            </div>
            <div class="p-card-buttons">
                <button>
                    <a href="#" class="fa fa-check-square-o" data-toggle="modal" data-target="#chatModal"
                        data-url="{{ $url_buttons['tasks_card'] }}"> Tareas</a>
                </button>
                {{-- <button>
                    <a href="#" class="fa fa-comment" data-toggle="modal" data-target="#chatModal" data-url="{{ $url_buttons['tasks_card'] }}"></a>
                </button>
                <button>
                    <a href="#" class="fa fa-comment" data-toggle="modal" data-target="#chatModal" data-url="{{ $url_buttons['tasks_card'] }}"></a>
                </button> --}}
            </div>
        @endif
    </div>
</div>
