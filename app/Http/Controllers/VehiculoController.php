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

        $url = 'https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_ConsultaDGTT/Frm_rep_intra_mercancia_display.aspx';

        $cookieFile = storage_path('app/mtc_cookie.txt');

        $ch = curl_init();

        /*
        |--------------------------------------------------------------------------
        | 1. GET INICIAL
        |--------------------------------------------------------------------------
        */

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_USERAGENT => 'Mozilla/5.0',
        ]);

        $html = curl_exec($ch);

        if ($html === false || empty($html)) {

            return response()->json([
                'success' => false,
                'step' => 'GET',
                'curl_error' => curl_error($ch),
                'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | EXTRAER TOKENS ASP.NET
        |--------------------------------------------------------------------------
        */

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new DOMXPath($dom);

        $getInputValue = function ($name) use ($xpath) {

            $node = $xpath->query("//input[@name='$name']");

            if ($node->length > 0) {
                return $node->item(0)->getAttribute('value');
            }

            return '';
        };

        $viewState = $getInputValue('__VIEWSTATE');
        $eventValidation = $getInputValue('__EVENTVALIDATION');
        $viewStateGenerator = $getInputValue('__VIEWSTATEGENERATOR');

        /*
        |--------------------------------------------------------------------------
        | 2. POST
        |--------------------------------------------------------------------------
        */

        $postData = [
            '__VIEWSTATE' => $viewState,
            '__VIEWSTATEGENERATOR' => $viewStateGenerator,
            '__EVENTVALIDATION' => $eventValidation,

            'rbOpciones' => 2,
            'txtValor' => $ruc,
            'hdopcion' => 2,
            'hdvalore' => $ruc,
            'hdopc' => 2,
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $retorno = curl_exec($ch);
        // return $retorno;
        if ($retorno === false || empty($retorno)) {

            return response()->json([
                'success' => false,
                'step' => 'POST',
                'curl_error' => curl_error($ch),
                'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            ]);
        }

        curl_close($ch);

        /*
        |--------------------------------------------------------------------------
        | SCRAPING RESULTADO
        |--------------------------------------------------------------------------
        */

        $dom2 = new DOMDocument();
        @$dom2->loadHTML($retorno);

        $xpath2 = new DOMXPath($dom2);
        // return $dom2;
        // $columnSelector = '//table//tr/td[2]';

        $retorno_array = [];

        $rows = $xpath2->query('//*[@id="lblHtml"]//table//tr');
        // dd([
        //     'html' => $retorno,
        //     'rows_length' => $rows->length,
        //     'first_row' => $rows->length > 0
        //         ? $rows->item(0)->ownerDocument->saveHTML($rows->item(0))
        //         : null,
        // ]);
        for ($i = 1; $i < $rows->length; $i++) {

            $cols = $rows->item($i)->getElementsByTagName('td');

            if ($cols->length >= 4) {

                $retorno_array[] = [
                    'item' => trim($cols->item(0)->nodeValue),
                    'codigo' => trim($cols->item(1)->nodeValue),
                    'razon_social' => trim($cols->item(2)->nodeValue),
                    'ruc' => trim($cols->item(3)->nodeValue),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'cod_mtc' => $retorno_array,
        ]);
        
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