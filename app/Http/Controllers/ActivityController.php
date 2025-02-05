<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ProjectManager;
use App\Activity;

class ActivityController extends Controller {
    public function getModalData() {
        $users = User::all()->mapWithKeys(function ($item) {
            $value = $item->nombre ?? $item->name;
            return [$item->id => $value];
        });

        $dataUsers = [];

        foreach ($users as $clave => $nombre) {
            $dataUsers[$clave] = $nombre;
        }

        return [
            'users' => $dataUsers,
            'estados' => Activity::getStatuses()
        ];
    }

    public function create($project_id) {
        $project = ProjectManager::findOrFail($project_id);

        $modalData = $this->getModalData();
        $formRoute = route('project_managers.cards.store', [$project_id]);

        return view('project_manager.modals.form-card', [
            'model' => new Activity(),
            'formMethod' => 'POST',
            'formRoute' => $formRoute,
            'modalData' => $modalData,
            'project_id' => $project_id
        ]);
    }

    public function store(Request $request, $project_id) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'estado' => 'required|integer',
            'color' => 'required|string',
        ]);

        $project = ProjectManager::findOrFail($project_id);

        $activity = new Activity([
            'proyecto_id' => $project_id,
            'responsable_id' => $request->responsable_id,
            'nombre' => $request->nombre,
            'contenido' => $request->contenido,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_cierre' => $request->fecha_cierre,
            'estado' => $request->estado,
            'color' => $request->color,
        ]);

        if ($request->hasfile('foto')) {
            $image1 = $request->file('foto');
            $name = time() . $image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/project_manager/');
            $image1->move($destinationPath, $name);
        } else {
            $name = null;
        }

        $activity->foto = $name;

        $activity->save();

        return redirect()->route('project_managers.show', $project_id)->with('success', 'Tarjeta creada exitosamente');
    }

    public function edit($project_id, $id) {
        $activity = Activity::where('id', $id)->where('proyecto_id', $project_id)->firstOrFail();

        $modalData = $this->getModalData();
        $formRoute = route('project_managers.cards.update', [$project_id, $activity->id]);
        return view('project_manager.modals.form-card', [
            'model' => $activity,
            'formMethod' => 'PUT',
            'formRoute' => $formRoute,
            'modalData' => $modalData,
            'project_id' => $project_id,
            'activity' => $activity
        ]);
    }

    public function update(Request $request, $project_id, $id) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'estado' => 'required|integer',
            'color' => 'required|string'
        ]);

        $activity = Activity::findOrFail($id);

        $name = $activity->foto;

        if ($request->hasfile('foto')) {
            $image1 = $request->file('foto');
            $name = time() . '_' . $image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/project_manager/');
            $image1->move($destinationPath, $name);
        }

        $activity->update([
            'responsable_id' => $request->responsable_id,
            'nombre' => $request->nombre,
            'contenido' => $request->contenido,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_cierre' => $request->fecha_cierre,
            'estado' => $request->estado,
            'color' => $request->color,
            'foto' => $name
        ]);

        return redirect()->route('project_managers.show', $project_id)->with('success', 'Tarjeta actualizada exitosamente');
    }

    public function destroy($project_id, $id) {
        $activity = Activity::where('id', $id)->where('proyecto_id', $project_id)->firstOrFail();

        if ($activity->delete()) {
            return redirect()->route('project_managers.show', $project_id)->with('success', 'Tarjeta eliminada correctamente');
        } else {
            return redirect()->route('project_managers.show', $project_id)->with('error', 'Error al eliminar la tarjeta');
        }
    }
}
