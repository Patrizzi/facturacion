<?php
namespace App\Http\Controllers;
use App\Garantia;
use Illuminate\Http\Request;

class GarantiaController extends Controller
{

    public function index()
    {
        $garantia=Garantia::all();
        $conteo=Garantia::where('estado',0)->count();
        return view('configuracion_general.garantia.index',compact('garantia','conteo'));
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
    public function create_with_ajax(Request $request){
        // Obtener el contador de manera eficiente
        $contador = (Garantia::max('id') ?? 0) + 1;
        $id = str_pad($contador, 3, '0', STR_PAD_LEFT);

        // Crear la Garantia
        Garantia::create([
            'id'         => $id,
            'descripcion'    => $request->get('descripcion_garantia') ?? 'Sin descripción',
            'estado'         => '0',
        ]);

        return response()->json(['success' => true, 'message' => 'Garantia creada correctamente']);
    }
    public function change_state(Request $request){

        $garantia = Garantia::find($request->get('id'));
        if($garantia->estado == 0){
            $garantia->estado = 1;
        }else{
            $garantia->estado = 0;
        }
        $garantia->save();

        return response()->json(['success' => true, 'message' => 'Estado de la garantia actualizado correctamente']);
    }

    public function edit_ajax(Request $request){

        $id = $request->get('garantia_edit_id');
        $garantia=Garantia::find($id);
        $cant_activo=Garantia::where('estado',0)->count();
        $unico=Garantia::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_garantia = 0;
      }
        $garantia->descripcion=strtoupper($request->get('descripcion_garantia'));
        $garantia->save();
        return response()->json(['success' => true, 'garantia' => $garantia]);
    }
}
