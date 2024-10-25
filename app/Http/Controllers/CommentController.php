<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Task;
use Auth;
use App\View\Components\ProjectManager\Activity\TaskChatView;

class CommentController extends Controller
{
    public function index($project_id, $activity_id, $task_id) {
        $task = Task::where('id', $task_id)->where('actividad_id', $activity_id)->firstOrFail();
        $comments = $task->comments()->get();

        $data = [
            'project_id' => $project_id,
            'activity_id' => $activity_id,
            'task' => $task,
            'comments' => $comments,
            'url_buttons' => [
                'edit_task' => route('project_managers.cards.tasks.edit', [$project_id, $activity_id, $task]),
                'delete_task' => route('project_managers.cards.tasks.destroy', [$project_id, $activity_id, $task]),
            ]
        ];

        return app(TaskChatView::class, ['data' => $data])->render();
    }

    public function Create(){
        return "desde el controller del create";
    }

    public function store(Request $request, $project_id, $activity_id, $task_id) {
        $request->validate([
            'contenido' => 'required|string',
        ]);
    
        $task = Task::findorFail($task_id);

        $comment = new Comment([
            'tarea_id' => $task->id,
            'user_id' => Auth::id(),
            'contenido' => $request->get('contenido')
        ]);
    
        if ($request->hasfile('foto')){
            $image1 = $request->file('foto');
            $name = time() . $image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/project_manager/');
            $image1->move($destinationPath, $name);
        } else {
            $name = null;
        }
    
        $comment->foto = $name;
        if($comment->save()) {
            return redirect()->route('project_managers.show', $project_id)->with('success', 'Comentario creado exitosamente');
        } else {
            return redirect()->route('project_managers.show', $project_id)->with('error', 'Error al crear el comentario');
        }
    }

    public function Update(){
        return "desde el controller del update";
    }

    public function Destroy(){
        return "desde el controller del destroy";
    }
}
