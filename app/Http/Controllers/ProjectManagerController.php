<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    public function index(){
        return view('project_manager.index');

    }
    public function create(){
        return "desde el controlador del create";
    }
    public function store(){
        return "desde el controlador del store";
    }
    public function show($id){
        return "desde el controlador el numero ".$id;
    }

    public function update(request $request, $id){
        return "desde el controlador del index";
    }

    public function destroy($id){
        return "desde el destroy el numero ".$id;
    }
    public function cards(){
        return "desde el controlador del cards";

    }
    public function gantt(){
        
    }
    public function report(){
        
    }
}
