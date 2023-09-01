<?php

namespace App\Http\Controllers;

use App\CategoriasEventos;
use App\Cliente;
use App\Eventos;
use App\EventosUsers;
use App\User;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eventos_show(Request $request)
    {
        $tipo = $request->tipo;
        // return $tipo;
        if ($tipo == "empty") {
            $eventos = Eventos::get();
        } else {
            $user_eventos = EventosUsers::where('user_id', (string)$tipo)->get();
            // return $user_eventos;
            foreach ($user_eventos as $ids_event) {
                $ids[] =  $ids_event->evento_id;
            }
            $eventos = Eventos::whereIn('id', $ids)->get();
        }
        // return $tipo;
        foreach ($eventos as  $events) {
            $category = CategoriasEventos::where('id', $events->categoria_id)->first();
            $evento_user_a = EventosUsers::where('evento_id', $events->id)->first();
            // return $evento_user_a->users->id;
            $response[] = array(
                "id" => $events->id,
                "start" => $events->fecha_inicio,
                "startStr" => $events->fecha_inicio,
                "title" => $events->titulo,
                // "textColor" => $color_Text,
                "description" => $events->descripcion,
                "end" => $events->fecha_final,
                "endStr" => $events->fecha_final,
                "id_color" => $category->id,
                "color" => $category->color,
                "name_color" => $category->titulo,
                "category" => $category->titulo,
                "all_day" => $events->all_day,
                "cliente_id" => $events->clientes->id,
                "cliente_name" => $events->clientes->nombre,
                "cliente_doc" => $events->clientes->numero_documento,
                "user_id" => $evento_user_a->users->id,
                "user_name" => $evento_user_a->users->nombre,
                // "rendering" => 'background',
            );
        }
        return response()->json($response);
        // return json_encode($response);

    }

    public function eventos_show_user()
    {
        // $var = auth()->user()->name;
        $eventos = Eventos::get();
        $user_eventos = EventosUsers::where('user_id', auth()->user()->id)->get();
        foreach ($user_eventos as $value => $ids_event) {
            $ids[$value] =  $ids_event->evento_id;
        }
        $eventos = Eventos::whereIn('id', $ids)->get();
        // return response()->json($eventos);
        // $response = array();
        foreach ($eventos as $key => $events) {
            $category = CategoriasEventos::where('id', $events->categoria_id)->first();
            $evento_user = EventosUsers::where('evento_id', $events->id)->first();
            $rgb = sscanf($category->color, "#%2x%2x%2x");
            list($r, $g, $b) = $rgb;

            // Calcula el brillo del color
            $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

            // Determina si el color es oscuro o claro
            if ($brightness < 128) {
                $color_Text =  "#ffff";
            } else {
                $color_Text =  "black";
            }
            $response[] = array(
                "id" => $events->id,
                "start" => $events->fecha_inicio,
                "startStr" => $events->fecha_inicio,
                "title" => $events->titulo,
                "textColor" => $color_Text,
                "description" => $events->descripcion,
                "end" => $events->fecha_final,
                "endStr" => $events->fecha_final,
                "id_color" => $category->id,
                "color" => $category->color,
                "name_color" => $category->titulo,
                "category" => $category->titulo,
                "all_day" => $events->all_day,
                "cliente_id" => $events->clientes->id,
                "cliente_name" => $events->clientes->nombre,
                "cliente_doc" => $events->clientes->numero_documento,
                "user_id" => $evento_user->users->id,
                "user_name" => $evento_user->users->nombre,
                // "rendering" => 'background',
            );
        }
        return response()->json($response);
        // return json_encode($response);

    }

    public function index()
    {
        $categories = CategoriasEventos::get();
        $clientes = Cliente::get();
        $user = User::where('estado', 1)->get();
        return view('eventos.index', compact('categories', 'clientes', 'user'));
    }

    public function evento_user()
    {
        $categories = CategoriasEventos::get();
        $clientes = Cliente::get();
        $user = User::where('estado', 1)->get();
        return view('eventos.user_index', compact('categories', 'clientes', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->get('all_day'))) {
            //* PARA ALLDAY HACER BUCLE QUE REGISTRE LOS DIAS ASIGNADOS HASTA LLEGAR AL FIN, HABILITAR EL ALL DAY EN PARACONTROLLER 
            $fecha_ini = $request->get('fecha_inicio') . 'T' . $request->get('hora_inicio');
            $fecha_fin = $request->get('fecha_fin') . 'T' . $request->get('hora_fin');
            $allday = 0;
        } else {
            $fecha_ini = $request->get('fecha_inicio');
            $fecha_fin = $request->get('fecha_fin');
            $allday = 1;
        }
        $evento = new Eventos();
        $evento->titulo = $request->get('title');
        $evento->cliente_id = $request->get('cliente_id');
        $evento->categoria_id = $request->get('categoria');
        $evento->descripcion = $request->get('description');
        $evento->fecha_inicio = $fecha_ini;
        $evento->fecha_final = $fecha_fin;
        $evento->all_day = $allday;
        $evento->user_create_id = auth()->user()->id;
        $evento->estado = 0;
        $evento->save();

        // Guardar eventos relacionados
        // $request->get('usuario')

        if ($request->get('usuario') == 'all_user') {
            $users = User::where('roles_id', 2)->get();
            foreach ($users as $user) {
                $eventos_user = new EventosUsers();
                $eventos_user->evento_id = $evento->id;
                $eventos_user->user_id = $user->id;
                $eventos_user->start = $fecha_ini;
                $eventos_user->save();
            }
        } else {
            $eventos_user = new EventosUsers();
            $eventos_user->evento_id = $evento->id;
            $eventos_user->user_id = $request->get('usuario');
            $eventos_user->start = $fecha_ini;
            $eventos_user->save();
        }
        return redirect()->route('eventos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function show(Eventos $eventos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function edit(Eventos $eventos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        $id = $request->get('id_evento');

        if (empty($request->get('all_day_edit'))) {
            //* PARA ALLDAY HACER BUCLE QUE REGISTRE LOS DIAS ASIGNADOS HASTA LLEGAR AL FIN, HABILITAR EL ALL DAY EN PARACONTROLLER 
            $fecha_ini = $request->get('fecha_inicio') . 'T' . $request->get('hora_inicio');
            $fecha_fin = $request->get('fecha_fin') . 'T' . $request->get('hora_fin');
            $allday = 0;
        } else {
            $fecha_ini = $request->get('fecha_inicio');
            $fecha_fin = $request->get('fecha_fin');
            $allday = 1;
        }


        $evento = Eventos::find($id);
        $evento->titulo = $request->get('title');
        $evento->cliente_id = $request->get('cliente_id');
        $evento->categoria_id = $request->get('categoria');
        $evento->descripcion = $request->get('description');
        $evento->fecha_inicio = $fecha_ini;
        $evento->fecha_final = $fecha_fin;
        $evento->all_day = $allday;
        $evento->user_create_id = auth()->user()->id;
        $evento->estado = 0;
        $evento->save();

        $user_evento = EventosUsers::where('evento_id', $id)->get();
        foreach ($user_evento as $events_user) {
            $events_user->user_id = $request->get('usuario');
            $events_user->start = $fecha_ini;
            $events_user->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eventos $eventos)
    {
        //
    }
}
