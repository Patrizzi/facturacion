@push('css') 
    @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/cards/task.css') }}">
    @endonce
@endpush
<div class="task" id="task-{{$task->id}}" data-task-id="{{$task->id}}" onclick="loadTaskComments({{$task->id}}, '{{ $url_buttons['load_comments'] }}')">
{{-- <div class="task" id="task-{{$task->id}}"> --}}
    <div class="task-content">
        <img src="{{ $user_foto }}" class="task-worker-image" alt="worker image">
        <div class="task-worker-name simple-truncate">{{ $user_name }}</div>
        <div class="task-text">
            <p class="truncate-text" truncate="70">
                {{ $contenido }}
            </p>
        </div>
        <div class="task-footer">
            <div class="progress-container">
                <div class="progress-bar-date">{{ $fecha_inicio }}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar-border">
                        <div class="progress-bar" style="background-color: #94f261; width: {{ $barra_progreso }}%;"></div>
                    </div>
                </div>
                <div class="progress-bar-text">{{ $barra_progreso }}%</div>
                {{-- <div class="task-action-icons">
                    @if($task->user_id == auth()->id())
                        <a href="#" class="fa fa-pencil-square-o task-buttons" data-toggle="modal" data-target="#dynamicModal" data-url="{{ $url_buttons['edit_task'] }}"></a>
                        <a href="#" class="fa fa-trash task-buttons delete-item"></a>
                        <form action="{{ $url_buttons['delete_task'] }}" method="POST" style="display: none;" class="delete-item-form">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                    <i class="fa fa-comment task-buttons" onclick="toggleChat('{{$task->activity->id}}', '{{$task->id}}')"></i>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <div class="task-chat-box" id="chat-box-{{$task->id}}">
        @if ($task->comments->isNotEmpty())
            <div class="task-chat-history" id="chat-history-{{$task->id}}">
                @foreach ($task->comments as $comment)
                    <x-project-manager.activity.comment :comment="$comment"/>
                @endforeach
            </div>
        @endif
        <div class="task-chat-input">
            <form action="{{ route('project_managers.cards.tasks.comments.store', [$task->activity->project_manager, $task->activity, $task]) }}" enctype="multipart/form-data" method="post" class="chat-input-form">
                @csrf
                <label for="file-input-{{ $task->id }}" class="file-input-label">
                    <i class="fa fa-image"></i>
                </label>
                <input type="file" id="file-input-{{ $task->id }}" class="file-input" name="foto" />
                <input type="text" name="contenido" placeholder="Escribe un mensaje..." class="form-control input-text">
                <button type="submit">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div> --}}
</div>