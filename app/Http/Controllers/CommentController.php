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

    public function store(Request $request) {   
        $request->validate([
            'contenido' => 'required|string',
        ]);
    
        $task = Task::find($request->task);
        
        if (!$task) {
            return redirect()->back()->withErrors(['error' => 'Tarea no encontrada']);
        }
    
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
        $comment->save();
    
        return redirect()->route('project_managers.cards', $task->activity->project_manager);
    }

    public function Update(){
        return "desde el controller del update";
    }

    public function Destroy(){
        return "desde el controller del destroy";
    }
}
