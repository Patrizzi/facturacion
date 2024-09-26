<div class="task" id="task-{{$task->id}}">
    <div class="task-content">
        <div class="task-text">
            <img src="{{ getImageUrl($task->user->avatar, 1) }}" class="task-worker-image" alt="worker image">
            <div class="task-worker-name">{{ $worker_name }}</div>
            <p class="truncate-text" truncate="70">
                {{$task->contenido}}
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
                <div class="task-action-icons">
                    @if($task->user_id == auth()->id())
                        <a class="fa fa-pencil-square-o task-buttons"></a>
                        <a href="#" class="fa fa-trash task-buttons"></a>
                    @endif
                    <i class="fa fa-comment" style="cursor: pointer;" onclick="toggleChat('chat-box-{{$task->id}}')"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="task-chat-box" id="chat-box-{{$task->id}}">
        @if ($task->comments->isNotEmpty())
            <div class="task-chat-history" id="chat-history-{{$task->id}}">
                @foreach ($task->comments as $comment)
                    <x-ProjectManager.Activity.Comment :comment="$comment"/>
                @endforeach
            </div>
        @endif
        <div class="task-chat-input">
            <form action="{{ route('project_manager.card.task.comment.store', [$task->actividad->projectManager , $task->actividad, $task]) }}" enctype="multipart/form-data" method="post" class="chat-input-form">
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
    </div>
</div>

<style>
    .task {
        background-color: #ffffff;
        border-radius: 5px;
        padding: 10px 10px 8px 10px;
        margin: 8px 3px 0px 3px;
        color: #333;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .task-content {
        font-weight: bold;
    }
    .task-header {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .task-worker-image {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        float: right;
        margin-left: 8px;
    }
    .task-worker-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-grow: 1;
        max-width: calc(60%);
        line-height: 1.2;
    }
    .task-worker-name {
        font-size: 11px;
        font-weight: bold;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .task-worker-time {
        color: gray;
        font-size: 7.5px;
    }
    .task-text {
        font-weight: 500;
        font-size: 9.5px;
        text-align: justify
    }
    .task-footer {
        margin-top: 3px;
    }
    .task-buttons {
        cursor: pointer;
    }
    .task-action-icons {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
        margin-right: 3px;
        margin: 1px;
        justify-items: auto;
        font-size: 14px;
    }
    .task-chat-box {
        display: block;
        background-color: #f1f1f1;
        border-radius: 15px;
        max-height: 0;
        padding: 0px;
        margin: 0px;
        width: calc(100% - 5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease, margin 0.3s ease;
    }
    .task-chat-history {
        max-height: 120px;
        overflow-y: auto;
        margin-top: 3px;
        margin-bottom: 5px;
        font-size: 12px;
        border-radius: 10px;
    }
    .task-chat-history::-webkit-scrollbar {
        width: 2px;
    }
    .task-chat-history::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .task-chat-input {
        display: block;
        justify-content: space-between;
        margin: 0px;
    }
    .task-chat-input .chat-input-form {
        display: flex;
    }
    .task-chat-input input {
        flex-grow: 1;
        border: none;
        padding: 3px 8px 3px 8px;
        border-radius: 20px;
        margin: 0 5px;
    }
    .task-chat-input .file-input {
        display: none;
    }
    .task-chat-input input:focus {
        outline: none;
    }
    .task-chat-input button {
        border: none;
        margin: 2px;
        padding: 0px;
    }
    .task-chat-input label {
        cursor: pointer;
        margin: 2px;
        outline: none;
    }
    .task-chat-input i {
        cursor: pointer;
        margin: 2px;
        outline: none;
    }
    .task-chat-input .input-text {
        font-size: 10px;
        flex-grow: 1;
    }
</style>
