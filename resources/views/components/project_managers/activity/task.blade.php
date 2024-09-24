<div class="task" id="task-{{$task->id}}">
    <div class="task-worker-header">
        <img src="{{ isset($task->user->avatar) ? asset('/profile/images/') . '/' . $task->user->avatar : 'https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png' }}" class="worker-image" alt="worker image">
        <div class="task-worker-info">
            <div class="worker-name">{{ Str::ucfirst($task->user->nombre ?? $task->user->name) }}</div>
            <div class="worker-time">{{createdTime($task)}}</div>
        </div>
    </div>
    <div class="task-text">
        <p class="truncate-text" truncate="100">
            {{$task->contenido}}
        </p>
    </div>
    <div class="task-footer">
        <div class="progress-container">
            <div class="progress-bar-date">{{$task->fecha_inicio->format('d/m/Y')}}</div>
            <div class="progress-bar-container">
                <div class="progress-bar-border">
                    <div class="progress-bar" style="background-color: #94f261;  width: {{progressDate($task->fecha_inicio, $task->fecha_cierre)}}%;"></div>
                </div>
            </div>
            <div class="progress-bar-text">{{progressDate($task->fecha_inicio, $task->fecha_cierre)}}%</div>
            <div class="task-action-icons">
                @if($task->user_id == auth()->id())
                    <a class="fa fa-pencil-square-o task-buttons"></a>
                    <a href="#" class="fa fa-trash task-buttons" data: { confirm: 'Estás seguro?' }></a>
                @endif
                <i class="fa fa-comment" style="cursor: pointer;" onclick="toggleChat('chat-box-{{$task->id}}')"></i>
            </div>
        </div>
    </div>
    <div class="chat-box" id="chat-box-{{$task->id}}">
        @if ($task->comments->isNotEmpty())
            <div class="chat-history" id="chat-history-{{$task->id}}">
                @foreach ($task->comments as $comment)
                    <x-project_managers.activity.comment :task="$task" :comment="$comment"/>
                @endforeach
            </div>
        @endif
        <form action="" class="chat-input">
            <label for="file-input-1" class="file-input-label"><i class="fa fa-image"></i></label>
            <input id="file-input-1" type="file" class="file-input" name="attachments[image]">
            <input type="text" placeholder="Escribe un mensaje...">
            <button type="submit"><i class="fa fa-paper-plane"></i></button>
        </form>
    </div>
</div>