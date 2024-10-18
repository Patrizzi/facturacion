<?php

namespace App\Http\Controllers;

use App\ProjectManager;
use App\Activity;
use App\ProjectService;
use App\User;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    private $activities;
    private $projectServices;
    private $responsables;

    public function __construct(Activity $activity,ProjectService $projectService,User $responsable)
    {
        $this->activities=$activity::pluck('nombre','id');
        $this->projectServices=$projectService::pluck('nombre','id');
        $this->responsables=$responsable::pluck('name','id');
    }

    public function getDataForm($id = null)
    {
        $dataActivitie=[];
        $dataProjectService = [];
        $dataResponsable=[];

        foreach ($this->activities as $clave => $nombre){
            $dataActivitie[$clave]=$nombre;
        }
        foreach ($this->projectServices as $clave =>$nombre){
            $dataProjectService[$clave]=$nombre;
        }
        foreach ($this->responsables as $clave =>$nombre){
            $dataResponsable[$clave]=$nombre;
        }

        $dataForm=[
            'actividades'   => $dataActivitie,
            'projectServices'   => $dataProjectService,
            'responsables'  => $dataResponsable,
        ];
        
        return ($id==null)
            ? $dataForm
            : $dataForm+['project_manager'=>ProjectManager::findOrFail($id)];
    }

    public function index()
    {
        $tabla = ProjectManager::orderBy('id', 'asc')->get();
        return view('project_manager.index', compact('tabla'));
    }

    public function create()
    {
        return view('project_manager.create',$this->getDataForm());
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
            'fecha_cierre'=>'required',
            'prioridad' => $numbers
        ]);
        ProjectManager::create($request->all());
        return redirect()->route('project_managers.index')->with('success', 'Creado exitosamente');
    }
    public function show($id)
    {
        $project_manager = ProjectManager::findOrFail($id);
        return view('project_manager.show', compact('project_manager'));
    }

    public function edit($id)
    {
        return view('project_manager.edit', $this->getDataForm($id));
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
            'fecha_cierre'=>'required',
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
