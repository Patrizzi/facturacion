<?php

namespace App\Http\Controllers;

use App\ProjectManager;
use App\Cliente;
use App\ProjectService;
use App\User;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller {
    private $responsables;
    private $projectServices;
    private $administradores;

    public function __construct(Cliente $responsable, ProjectService $projectService, User $administrador) {
        $this->responsables = $responsable::pluck('nombre', 'id');
        $this->projectServices = $projectService::pluck('nombre', 'id');
        $this->administradores = $administrador::pluck('name', 'id');
    }

    private function getDataForm($id = null) {
        $dataResponsable = [];
        $dataProjectService = [];
        $dataAdministrador = [];

        foreach ($this->responsables as $clave => $nombre) {
            $dataResponsable[$clave] = $nombre;
        }
        foreach ($this->projectServices as $clave => $nombre) {
            $dataProjectService[$clave] = $nombre;
        }
        foreach ($this->administradores as $clave => $nombre) {
            $dataAdministrador[$clave] = $nombre;
        }

        $dataForm = [
            'responsables' => $dataResponsable,
            'projectServices' => $dataProjectService,
            'administradores' => $dataAdministrador,
        ];

        return ($id == null)
            ? $dataForm
            : $dataForm + ['project_manager' => ProjectManager::findOrFail($id)];
    }

    private function buttonsActions(string $button): array {
        $buttons = [
            "newProject" => [
                "text" => "Nuevo Proyecto",
                "attributes" => ["href" => route("project_managers.create")]
            ]
        ];

        return $buttons[$button];
    }

    public function index() {
        $data = ProjectManager::orderBy('id', 'asc')->paginate(10);
        $button = [$this->buttonsActions("newProject")];
        return view('project_manager.index', compact('data', 'button'));
    }

    public function create() {
        return view('project_manager.create', $this->getDataForm());
    }

    public function store(Request $request) {
        $numbers = ['required', 'integer', 'min:1'];
        $request->validate([
            'nombre', 'centro_costo',
            'ruc' => 'required',
            'administrador_id' => $numbers,
            'responsable_id' => $numbers,
            'project_service_id' => $numbers,
            'cliente_id' => $numbers,
            'fecha_inicio' => 'required',
            'fecha_cierre' => 'required',
            'prioridad' => $numbers
        ]);
        ProjectManager::create($request->all());
        return redirect()->route('project_managers.index')->with('success', 'Creado exitosamente');
    }
    public function show($id) {
        return view('project_manager.show', $this->getDataForm($id));
    }

    public function edit($id) {
        return view('project_manager.edit', $this->getDataForm($id));
    }

    public function update(Request $request, $id) {
        $numbers = ['required', 'integer', 'min:1'];
        $request->validate([
            'nombre', 'centro_costo',
            'ruc' => 'required',
            'administrador_id' => $numbers,
            'responsable_id' => $numbers,
            'project_service_id' => $numbers,
            'cliente_id' => $numbers,
            'fecha_inicio' => 'required',
            'fecha_cierre' => 'required',
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

        $buttons = [
            [
                'text' => 'Agregar Tarjeta',
                'attributes' => ['href' => '#', 'data-toggle' => 'modal', 'data-target' => '#dynamicModal', 'data-url' => route('project_managers.cards.create', $project_manager->id)],
                'visible' => true,
            ],
            [
                'text' => 'Tarjetas',
                'attributes' => ['href' => route('project_managers.cards', $project_manager->id)],
                'visible' => true,
            ],
        ];

        $activities = $project_manager->activities()->with([
            'responsable',
            'tasks.user',
            'tasks.comments.user'
        ])->paginate(5);

        return view('project_manager.activities', compact('project_manager', 'activities', 'buttons'));
    }

    public function gantt() {
        $data = ProjectManager::orderBy('id', 'asc')->paginate(10);
        $buttons = [
            [
                "text" => "Proyectos",
                "attributes" => ["href" => route("project_managers.index")]
            ],
            [
                "text" => "Gantt",
                "attributes" => ["href" => route("project_managers.gantt.index")]
            ]
        ];
        return view('project_manager.index-gantt', compact('data', 'buttons'));
    }

    public function report() {
        $data = ProjectManager::all();
        return view('project_manager.report', compact('data'));
    }
}
