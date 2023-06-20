<?php
namespace App\Http\Controllers;

use App\TransportePublico;
use App\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculo=Vehiculo::all();
        $transporte_publico=TransportePublico::all();
        return view('planilla.vehiculo.index',compact('vehiculo','transporte_publico'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        // Tipo de Vehiculo
            // 0 Auto Particular
            // 1 Moto ->cambio en config_fe para 1ML
            // 2 Camioneta
            // 3 Omnibus
            // 4 Minivan
            
        $categoria=$request->get('categoria');

        if ($categoria=='create_publico') {
            $vehiculo=new TransportePublico;
            $vehiculo->nombre=$request->get('nombre');
            $vehiculo->ruc=$request->get('ruc');
            $vehiculo->numero_mtc=$request->get('n_mtc');
            $vehiculo->estado='0';
            $vehiculo->save();
        }
        elseif($categoria=='create_privado'){
            $vehiculo=new Vehiculo;
            $vehiculo->tipo_vehiculo=$request->get('tipo_vehiculo');
            $vehiculo->placa=$request->get('placa');
            $vehiculo->marca=$request->get('marca');
            $vehiculo->modelo=$request->get('modelo');
            $vehiculo->certificado_inscripcion=$request->get('certificado_inscripcion');
            $vehiculo->año=$request->get('año');
            $vehiculo->estado_activo='0';
            $vehiculo->save();
        }


        return redirect()->route('vehiculo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        // Tipo de Vehiculo
        // Categoría L (Vehículo con menos de cuatro ruedas) </option> {{-- VEHICULOS L --}}
        // Categoría M (Vehículo de 3 o 4 ruedas y es utilizado para el transporte de pasajeros)</option>  {{-- VEHICULOS M --}}
        // Categoría M1 (Autos, taxis y SUV)
        // Categoría N (Vehículo de 4 ruedas y sea para transporte de carga.)</option> {{-- VEHICULOS N --}}
        // Categoría O (Semirremolques y volquetes)</option>{{-- VEHICULOS O --}}

        $categoria=$request->get('categoria');
        if ($categoria=='update_publico') {
            $estado=$request->get('estado');
            if(isset($estado)){
                $estado_numero='0';
            }else{
                $estado_numero='1';
            }
            $vehiculo=TransportePublico::find($id);
            $vehiculo->nombre=$request->get('nombre');
            $vehiculo->ruc=$request->get('ruc');
            $vehiculo->numero_mtc=$request->get('numero_mtc');
            $vehiculo->estado=$estado_numero;
            $vehiculo->save();

        }elseif($categoria=='update_privado'){
            $estado=$request->get('estado');
            if(isset($estado)){
                $estado_numero='0';
            }
            else{
                $estado_numero='1';
            }
            $vehiculo=Vehiculo::find($id);
            // $vehiculo->tipo_vehiculo
            $vehiculo->placa=$request->get('placa');
            $vehiculo->tipo_vehiculo=$request->get('tipo_vehiculo');
            $vehiculo->marca=$request->get('marca');
            $vehiculo->modelo=$request->get('modelo');
            $vehiculo->certificado_inscripcion=$request->get('certificado_inscripcion');
            $vehiculo->año=$request->get('año');
            $vehiculo->estado_activo=$estado_numero;
            $vehiculo->save();
        }

        return redirect()->route('vehiculo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }


}