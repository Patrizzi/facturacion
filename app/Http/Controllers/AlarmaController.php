<?php
namespace App\Http\Controllers;
use App\Alarma;
use Illuminate\Http\Request;

class AlarmaController extends Controller
{

    public function index()
    {
        
    }


    public function store(Request $request)
    {
        
    }


    public function update(Request $request, $id)
    {
         //ESTADO

    }
    public function create_with_ajax(Request $request){
        // Obtener el contador de manera eficiente
        $contador = (Alarma::max('id') ?? 0) + 1;
        $id = str_pad($contador, 2, '0', STR_PAD_LEFT);

        // Crear la Garantia
        Alarma::create([
            'id'         => $id,
            'descripcion'    => $request->get('descripcion_alarma') ?? 'Sin descripción',
            'tipo' =>$request->get('tipo_alarma')?? 'Sin tipo',
            'alarma' =>$request->get('alarma_alarma'),
            'estado'         => '0',
        ]);

        return response()->json(['success' => true, 'message' => 'Alarma creada correctamente']);
    }
    public function change_state(Request $request){

        $alarma = Alarma::find($request->get('id'));
        if($alarma->estado == 0){
            $alarma->estado = 1;
        }else{
            $alarma->estado = 0;
        }
        $alarma->save();

        return response()->json(['success' => true, 'message' => 'Estado de la alarma actualizado correctamente']);
    }

    public function edit_ajax(Request $request){

        $id = $request->get('alarma_edit_id');
        $alarma=Alarma::find($id);
        $cant_activo=Alarma::where('estado',0)->count();
        $unico=Alarma::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_alarma = 0;
      }
        $alarma->descripcion=strtoupper($request->get('descripcion_alarma'));
        $alarma->tipo=strtoupper($request->get('tipo_alarma'));
        $alarma->save();
        return response()->json(['success' => true, 'alarma' => $alarma]);
    }
}
