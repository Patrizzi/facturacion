<div class="modal-content" id="modal-chat-card-{{ $data['activity']->id }}">
    <div class="modal-header">
        <h5 class="modal-title" id="chatModalLabel">Tareas de la Actividad "{{ $data['activity']->nombre }}".</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if ($data['tasks']->isNotEmpty())
            <div class="tasks-list">
                    @foreach ($data['tasks'] as $task)
                        <x-project-manager.activity.task :task="$task"/>
                    @endforeach
            </div>
            <div class="task-comment-history">
                <!-- Aqui cargarian los comentarios-->
            </div>
        @else
            <h5>No hay tareas en esta actividad</h5>
        @endif
    </div>
</div>