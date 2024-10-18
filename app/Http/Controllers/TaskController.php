<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Task;
use App\Activity;

class TaskController extends Controller
{
    public function getModalData() {
        return [
            'users' => User::select('id', 'name')->get(),
            'estados' => Task::getStatuses()
        ];
    }

    public function create($project_id, $activity_id) {
        $activity = Activity::where('id', $activity_id)
                            ->where('proyecto_id', $project_id)
                            ->firstOrFail();

        $modalData = $this->getModalData();
        $formRoute = route('project_managers.cards.tasks.store', [$project_id, $activity_id]);

        return view('project_manager.modals.form-task', [
            'model' => new Task(),
            'formMethod' => 'POST',
            'formRoute' => $formRoute,
            'modalData' => $modalData,
            'activity' => $activity,
            'project_id' => $project_id 
        ]);
    }

    public function store(Request $request, $project_id, $activity_id) {
        $request->validate([
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'estado' => 'required|integer',
        ]);

        $activity = Activity::where('id', $activity_id)
                            ->where('proyecto_id', $project_id)
                            ->firstOrFail();

        $task = new Task([
            'actividad_id' => $activity_id,
            'user_id' => $request->user_id,
            'contenido' => $request->contenido,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_cierre' => $request->fecha_cierre,
            'estado' => $request->estado,
        ]);

        $task->save();

        return redirect()->route('project_managers.cards', $project_id)->with('success', 'Tarea creada exitosamente');
    }

    public function edit($project_id, $activity_id, $id) {
        $task = Task::where('id', $id)->where('actividad_id', $activity_id)->firstOrFail();
        
        $modalData = $this->getModalData();

        $formRoute = route('project_managers.cards.tasks.update', [$task->activity->project_manager, $task->activity, $task]);
        return view('project_manager.modals.form-task', [
            'model' => $task,
            'formMethod' => 'PUT',
            'formRoute' => $formRoute,
            'modalData' => $modalData,
            'project_id' => $project_id,
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'estado' => 'required|integer',
        ]);

        $task = Task::findorFail($request->task);
        
        $task->update([
            'user_id' => $request->user_id,
            'contenido' => $request->contenido,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_cierre' => $request->fecha_cierre,
            'estado' => $request->estado,
        ]);
        
        return redirect()->route('project_managers.cards', $task->activity->project_manager)->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy($project_id, $activity_id, $id) {
        $task = Task::where('id', $id)->where('actividad_id', $activity_id)->firstOrFail();

        if($task->delete()){
            return redirect()->route('project_managers.cards', $project_id)->with('success', 'Tarea eliminada correctamente');
        } else {
            return redirect()->route('project_managers.cards', $project_id)->with('error', 'Error al eliminar la tarea');
        }
    }
}
