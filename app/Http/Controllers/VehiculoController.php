<?php
namespace App\Http\Controllers;

use App\TransportePublico;
use App\Vehiculo;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;


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
    public function scrapping_mtc(Request $request){

        $ruc = $request->get('ruc');
        $url = 'https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_ConsultaDGTT/Frm_rep_intra_mercancia_display.aspx'; // Reemplaza esta URL por la página que deseas scrapear

        $data = [
            '__VIEWSTATE' => '/wEPDwUKLTk2MjgwMjM4NWRkdLR4EEmI6H/Gq0VM2km2uPyg+i4=',
            '__VIEWSTATEGENERATOR' => '11454F71',
            '__EVENTVALIDATION' => '/wEWCALDzKq+CQLL98WuCwLI98WuCwLJ98WuCwLO98WuCwLFmO/ABwLm+7rTBwK674/pDE754lgXafISz9MUO/Y+ZXqam9WK',
            'rbOpciones' => 2,
            'txtValor' => $ruc,
            'hdopcion' => 2,
            'hdvalore' => $ruc,
            'hdopc' => 2,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $retorno = curl_exec($ch);

        curl_close($ch);

         $dom = new DOMDocument();
         @$dom->loadHTML($retorno); // El "@" se utiliza para suprimir los errores que puedan generarse al analizar el HTML
         $xpath = new DOMXPath($dom);
 
        $columnSelector = '//table//tr/td[2]';

        $retorno_aray = [];
        $nodes = $xpath->query($columnSelector);
        // Empezar el bucle desde el segundo elemento
        for ($i = 1; $i < $nodes->length; $i++) {
            $node = $nodes->item($i);
            $retorno_aray[] = $node->nodeValue;
        }

        $new = [
            'cod_mtc' => $retorno_aray
        ];
        return $new;
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