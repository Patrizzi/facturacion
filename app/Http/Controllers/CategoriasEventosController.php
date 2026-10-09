<?php

namespace App\Http\Controllers;

use App\CategoriasEventos;
use Illuminate\Http\Request;

class CategoriasEventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoriasEventos::get();
        return view('eventos.categorias.index',compact('categories'));
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
        $category = new CategoriasEventos;
        $category->titulo = $request->get('name');
        $category->descripcion = $request->get('description');
        $category->color = $request->get('color');
        $category->user_create_id = auth()->user()->id;
        $category->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CategoriasEventos  $categoriasEventos
     * @return \Illuminate\Http\Response
     */
    public function show(CategoriasEventos $categoriasEventos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoriasEventos  $categoriasEventos
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoriasEventos $categoriasEventos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoriasEventos  $categoriasEventos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = $request->get('id');
        $categori = CategoriasEventos::find($id);
        $categori->titulo = $request->get('name');
        $categori->descripcion = $request->get('description');
        $categori->color = $request->get('color');
        if($request->get('estado') == "on"){
            $categori->estado = 0;
        }else{
            $categori->estado = 1;
        }
        
        $categori->save();
        return "exito";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoriasEventos  $categoriasEventos
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoriasEventos $categoriasEventos)
    {
        //
    }
}
