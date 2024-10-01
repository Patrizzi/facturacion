<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function Create(){
        return "desde el controller del create";
    }

    public function Store(){
        return "desde el controller del store";
    }

    public function Update(){
        return "desde el controller del update";
    }

    public function Destroy(){
        return "desde el controller del destroy";
    }
}
