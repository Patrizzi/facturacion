<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Task;
use Auth;

class CommentController extends Controller
{
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
            return redirect()->route('project_managers.cards', $project_id)->with('success', 'Comentario creado exitosamente');
        } else {
            return redirect()->route('project_managers.cards', $project_id)->with('error', 'Error al crear el comentario');
        }
    }

    public function Update(){
        return "desde el controller del update";
    }

    public function Destroy(){
        return "desde el controller del destroy";
    }
}
