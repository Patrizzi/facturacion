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
    public function eventos_show()
    {
        $var = auth()->user()->name;
        // if ($var == "Administrador") {
        $eventos = Eventos::get();
        // } else {
        //     $user_eventos = EventosUsers::where('user_id', auth()->user()->id)->get();
        //     foreach ($user_eventos as $value => $ids_event) {
        //         $ids[$value] =  $ids_event->evento_id;
        //     }
        //     $eventos = Eventos::whereIn('id', $ids)->get();
        // }
        // return response()->json($eventos);
        // $response = array();
        foreach ($eventos as $key => $events) {
            $category = CategoriasEventos::where('id', $events->categoria_id)->first();
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
        //
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
    public function update(Request $request, Eventos $eventos)
    {
        //
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
