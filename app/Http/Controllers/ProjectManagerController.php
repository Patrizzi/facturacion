<?php

namespace App\Http\Controllers;

use App\ProjectManager;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    public function index()
    {
        $tabla = ProjectManager::orderBy('id', 'asc')->get();
        return view('project_manager.index', compact('tabla'));
    }

    public function create()
    {
        return view('project_manager.create');
    }

    public function store(Request $request)
    {
        $numbers=['required','integer','min:1'];
        $request->validate([
            'nombre','centro_costo',
            'ruc'=>'required',
            'administrador_id' => $numbers,
            'responsable_id' => $numbers,
            'project_service_id' => $numbers,
            'cliente_id' => $numbers,
            'fecha_inicio'=>'required',
            'fecha_final'=>'required',
            'prioridad' => $numbers
        ]);
        ProjectManager::create($request->all());
        return redirect()->route('project_managers.index')->with('success', 'Creado exitosamente');
    }
    public function show($id)
    {
        $data = ProjectManager::findOrFail($id);
        return view('project_manager.show', compact('data'));
    }

    public function edit($id)
    {
        $data = ProjectManager::findOrFail($id);
        return view('project_manager.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $numbers=['required','integer','min:1'];
        $request->validate([
            'nombre','centro_costo','ruc'=>'required',
            'ruc'=>'required',
            'administrador_id' => $numbers,
            'responsable_id' => $numbers,
            'project_service_id' => $numbers,
            'cliente_id' => $numbers,
            'fecha_inicio'=>'required',
            'fecha_final'=>'required',
            'prioridad' => $numbers
        ]);
        $data = ProjectManager::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('project_managers.index')->with('success', 'Actualizado exitosamente');
    }

    public function destroy($id) {
        $tabla = ProjectManager::findOrFail($id);
        $tabla->delete();
        return redirect()->route('project_managers.index');
    }

    public function cards($id) {
        $project_manager = ProjectManager::select('id', 'nombre')->findOrFail($id);
        
        $activities = $project_manager->activities()->with([
            'responsable',
            'tasks.user',
            'tasks.comments.user'
        ])->paginate(5);

        return view('project_manager.activities', compact('project_manager', 'activities'));
    }

    public function gantt()
    {
        $data = ProjectManager::all();
        return view('project_manager.gantt', compact('data'));
    }

    public function report()
    {
        $data = ProjectManager::all();
        return view('project_manager.report', compact('data'));
    }
}
