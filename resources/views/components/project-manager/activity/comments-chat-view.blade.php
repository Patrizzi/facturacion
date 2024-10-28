<div class="task-chat-header">
    <h5>Historial de comentarios</h5>
    <div class="task-chat-action-icons">
        @if($data['task']->user_id == auth()->id())
            <a href="#" class="fa fa-pencil-square-o" data-toggle="modal" data-target="#formModal" data-url="{{ $data['url_buttons']['edit_task'] }}"></a>
            <a href="#" class="fa fa-trash" onclick="deleteItem('{{ $data['task']->id }}')"></a>
            <form action="{{ $data['url_buttons']['delete_task'] }}" method="POST" style="display: none;" id="delete-item-form-{{ $data['task']->id }}">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
</div>
<div class="task-chat-comments">
    @if ($data['comments']->isNotEmpty())
        @foreach ($data['comments'] as $comment)
            <x-project-manager.activity.comment :comment="$comment"/>
        @endforeach
    @else
        <h5>Aun no hay comentarios en esta tarea...</h5>
    @endif
</div>
<div class="task-chat-input">
    <form action="{{ route('project_managers.cards.tasks.comments.store', [$data['project_id'], $data['activity_id'], $data['task'] ]) }}" enctype="multipart/form-data" method="post" class="chat-input-form">
        @csrf
        <label for="file-input-{{ $data['task'] }}" class="file-input-label">
            <i class="fa fa-image"></i>
        </label>
        <input type="file" id="file-input-{{ $data['task'] }}" class="file-input" name="foto" />
        <textarea name="contenido" placeholder="Escribe un mensaje..." class="form-control input-textarea auto-resizable" rows="1" style=""></textarea>
        <button type="submit">
            <i class="fa fa-paper-plane"></i>
        </button>
    </form>
</div>