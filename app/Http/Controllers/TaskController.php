<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Task;
use App\Activity;
use App\View\Components\ProjectManager\Activity\TasksChatView;

class TaskController extends Controller
{
    // Funciones auxiliares
    public function getModalData() {
        return [
            'users' => User::select('id', 'name')->get(),
            'estados' => Task::getStatuses()
        ];
    }

    public function index($project_id, $activity_id) {
        $activity = Activity::with('tasks.user')
                            ->where('id', $activity_id)
                            ->where('proyecto_id', $project_id)
                            ->select('id', 'nombre')
                            ->firstOrFail();

        $data = [
            'project_id' => $project_id,
            'activity' => $activity, 
            'tasks' => $activity->tasks,
        ];
    
        return app(TasksChatView::class, ['data' => $data])->render();
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
            'project_id' => $project_id, 
            'activity' => $activity,
        ]);
    }

    public function store(Request $request, $project_id, $activity_id) {
        $request->validate([
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'estado' => 'required|integer',
        ]);

        try {
            $activity = Activity::where('id', $activity_id)
                                ->where('proyecto_id', $project_id)
                                ->firstOrFail();

            $task = $activity->tasks()->create($request->only(['user_id', 'contenido', 'fecha_inicio', 'fecha_cierre', 'estado']));

            return redirect()->route('project_managers.show', $project_id)->with('success', 'Tarea creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('project_managers.index')->with('error', 'Error al crear la tarea');
        }
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
            'activity_id' => $activity_id,
            'task' => $task,
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'estado' => 'required|integer',
        ]);

        $task = Task::findOrFail($request->task);
        $task->update($request->only(['user_id', 'contenido', 'fecha_inicio', 'fecha_cierre', 'estado']));
        
        return redirect()->route('project_managers.show', $task->activity->project_manager)->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy($project_id, $activity_id, $id) {
        $task = Task::where('id', $id)->where('actividad_id', $activity_id)->firstOrFail();

        if($task->delete()){
            return redirect()->route('project_managers.show', $project_id)->with('success', 'Tarea eliminada correctamente');
        } else {
            return redirect()->route('project_managers.show', $project_id)->with('error', 'Error al eliminar la tarea');
        }
    }
}
