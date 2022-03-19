<?php
namespace App\Http\Controllers;
use App\ClienteRetenedores;
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
        $retenedores=ClienteRetenedores::where('cliente_id',$id)->first();
        $estado = $request->get('estado');
        $porcentaje=$request->get('porcentaje');

        if($estado == "on" ){ $estado_retenedores = 0;}else{ $estado_retenedores = 1;}

        if (!isset($porcentaje)) {return redirect()->route('cliente.show',$id)->withErrors(['Numero Porsentaje % vacio']);}
        if (isset($retenedores)) {
            $cli_retenedores=ClienteRetenedores::find($retenedores->id);
            $cli_retenedores->porcentaje=$porcentaje;
            $cli_retenedores->estado=$estado_retenedores;
            $cli_retenedores->save();
        }
        else{
          $cli_retenedores=new ClienteRetenedores;
          $cli_retenedores->cliente_id=$id;
          $cli_retenedores->porcentaje=$porcentaje;
          $cli_retenedores->estado='0';
          $cli_retenedores->save();
      }

      return redirect()->route('cliente.show',$id);

  }
}
