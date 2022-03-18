<?php
namespace App\Http\Controllers;
use App\Garantia;
use Illuminate\Http\Request;

class ClienteRetenedoresController extends Controller
{

    public function index()
    {
        // $garantia=Garantia::all();
        // $conteo=Garantia::where('estado',0)->count();
        // return view('configuracion_general.garantia.index',compact('garantia','conteo'));
    }


    public function store(Request $request)
    {
        $garantia=new Garantia;
        $garantia->descripcion=$request->get('descripcion');
        $garantia->estado='0';
        $garantia->save();

        return redirect()->route('garantia.index');
    }


    public function update(Request $request, $id)
    {
         //ESTADO
        $estado = $request->get('estado');
        $nombre=$request->get('descripcion');

        if($estado == "on" ){ $estado_familia = 0;}
        else{ $estado_familia = 1;}
        if (empty($nombre)) {return redirect()->route('garantia.index')->withErrors(['Descripción Vacía, Debe ingresar Registros']);}

        $cant_activo=Garantia::where('estado',0)->count();
        $unico=Garantia::where('id',$id)->where('estado',0)->first();

        if ($cant_activo==1 && isset($unico)) { $estado_familia = 0; }

        $garantia=Garantia::find($id);
        $garantia->descripcion=$nombre;
        $garantia->estado=$estado_familia;
        $garantia->save();

        return redirect()->route('garantia.index');

    }
}
