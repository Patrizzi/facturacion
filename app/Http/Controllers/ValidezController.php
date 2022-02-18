<?php
namespace App\Http\Controllers;
use App\Garantia;
use App\Validez;
use Illuminate\Http\Request;

class ValidezController extends Controller
{

    public function index()
    {
        $validez=Validez::all();
        $conteo=Validez::where('estado',0)->count();
        return view('configuracion_general.validez.index',compact('validez','conteo'));
    }


    public function store(Request $request)
    {
        $validez=new Validez;
        $validez->descripcion=$request->get('descripcion');
        $validez->estado='0';
        $validez->save();

        return redirect()->route('validez.index');
    }


    public function update(Request $request, $id)
    {
         //ESTADO
        $estado = $request->get('estado');
        $nombre=$request->get('descripcion');

        if($estado == "on" ){ $estado_vali = 0;}
        else{ $estado_vali = 1;}
        if (empty($nombre)) {return redirect()->route('validez.index')->withErrors(['Descripción Vacía, Debe ingresar Registros']);}

        $cant_activo=Validez::where('estado',0)->count();
        $unico=Validez::where('id',$id)->where('estado',0)->first();

        if ($cant_activo==1 && isset($unico)) { $estado_vali = 0; }

        $validez=Validez::find($id);
        $validez->descripcion=$nombre;
        $validez->estado=$estado_vali;
        $validez->save();

        return redirect()->route('validez.index');

    }
}
