<?php

namespace App\Http\Controllers;
use App\Cliente;
use App\ClienteRetenedores;
use App\Cliente_sucursal;
use App\Contacto;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $clientes=Cliente::all();
      $contactos=Contacto::all();
      foreach ($clientes as  $cliente) {
        if($cliente->empresa == null){
          $cliente = Cliente::find($cliente->id);
          $cliente->empresa = $cliente->nombre;
          $cliente->save();
        }
      }
      return view('auxiliar.cliente.index',compact('clientes','contactos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $clientes=Cliente::all();
      return view('auxiliar.cliente.create',compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $documento_identificacion=$request->get('numero_documento');
     if(strstr($documento_identificacion,' ',true) == true){
      $doc_ruc = strstr($documento_identificacion,' ',true);
      // return "1";
    }else{
      $doc_ruc = $documento_identificacion;
      // return "2";
    }
    $cliente_existe=Cliente::where('numero_documento',$doc_ruc)->count();

    if ($cliente_existe==1) {
      return redirect()->route('cliente.index')->withErrors(['Cliente ya Agregado!']);
    }else{
     $cliente= new Cliente;
     $cliente->nombre=$request->get('nombre');
     $cliente->direccion=$request->get('direccion');
     $cliente->email=$request->get('email');
     $cliente->telefono=$request->get('telefono');
     $cliente->celular=$request->get('celular');
     $cliente->documento_identificacion=$request->get('documento_identificacion');
     $cliente->empresa=$request->get('nombre');
     $cliente->numero_documento=$request->get('numero_documento');
     $cliente->ciudad=$request->get('ciudad');
     $cliente->departamento=$request->get('departamento');
     $cliente->pais=$request->get('pais');
     $cliente->tipo_cliente=$request->get('tipo_cliente');
     $cliente->aniversario=$request->get('aniversario');
     /*Nota: el cod postal es código de UBIGEO, cuando se registra el cliente por el agre. rapido es Ubigeo, para envio a sunat es UBIGEO */
     $cliente->cod_postal=$request->get('cod_postal');
     $cliente->fecha_registro=$request->get('fecha_registro');
     $cliente->save();

     $contacto=new Contacto;
     $contacto->nombre=$request->get('nombre_contacto');
     $contacto->primer_contacto=1;
     $contacto->cargo=$request->get('cargo_contacto');
     $contacto->telefono=$request->get('telefono_contacto');
     $contacto->celular=$request->get('celular_contacto');
     $contacto->email=$request->get('email_contacto');
     $contacto->clientes_id=$cliente->id;
     $contacto->save();
     return redirect()->route('cliente.show',$cliente->id);
   }
 }

 public function storecontact($data)
 {


 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
      $cliente_rete=ClienteRetenedores::where('cliente_id',$id)->first();
      $cliente_show=Cliente::find($id);
      $cliente_sucursal=Cliente_sucursal::where('cliente_id',$id)->get();
      $contacto_show=Contacto::where('clientes_id','=',$id)->orderBy('primer_contacto','DESC')->get();
      $contacto_cantidad=Contacto::where('clientes_id',$id)->count();
      $contacto_cantidad_estado=Contacto::where('clientes_id',$id)->where('estado',0)->count();
      return view('auxiliar.cliente.show',compact('cliente_show','contacto_show','contacto_cantidad','contacto_cantidad_estado','cliente_rete','cliente_sucursal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $cliente=Cliente::find($id);
      return view('auxiliar.cliente.edit',compact('cliente'));
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
      $cliente= Cliente::find($id);
      $cliente->nombre=$request->get('nombre');
      $cliente->direccion=$request->get('direccion');
      $cliente->email=$request->get('email');
      $cliente->telefono=$request->get('telefono');
      $cliente->anexo=$request->get('anexo');
      $cliente->celular=$request->get('celular');
      $cliente->empresa=$request->get('empresa');
      $cliente->documento_identificacion=$request->get('documento_identificacion');
      $cliente->numero_documento=$request->get('numero_documento');
      $cliente->ciudad=$request->get('ciudad');
      $cliente->departamento=$request->get('departamento');
      $cliente->pais=$request->get('pais');
      $cliente->tipo_cliente=$request->get('tipo_cliente');
      $cliente->cod_postal=$request->get('ubigeo');
      $cliente->aniversario=$request->get('aniversario');
      $cliente->fecha_registro=$request->get('fecha_registro');
      
      $cliente->save();
      return redirect()->route('cliente.show',$cliente->id);
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

    function ruc(Request $request){
      // return $request->get('ruc');
      $ruc=$request->get('ruc');

      $data = file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/".$ruc."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlc2Fycm9sbG9Aanlwc2FjLmNvbSJ9.1Pt1A4PEFAGmFySlfVeFKZKuVCC-u_ZEW-KYQq-P57k");
      $info = json_decode($data, true);

      $clientes=Cliente::where('numero_documento',array($info['ruc']))->first();
      if (isset($clientes)) {
        $ruc_view=$clientes->numero_documento;
        $datos = array(
          0 => array($ruc),
          1 => array($clientes->empresa),
          2 => 'existente',
        );
        return json_encode($datos);
      }else{
        $ruc_view=array($info['ruc']);
      }

      $datos = array(
        0 => $ruc_view,
        1 => $info['razonSocial'],
        2 => $info['direccion'],
        3 => $info['provincia'],
        4 => $info['distrito'],
        5 => $info['fechaInscripcion'],
        6 => $info['ubigeo'],
      );
      return json_encode($datos);
    }
    //* API PARA DNI *//
    function dni(Request $request){
      $dni=$request->get('dni');
      $data = file_get_contents("https://dniruc.apisperu.com/api/v1/dni/".$dni."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlc2Fycm9sbG9Aanlwc2FjLmNvbSJ9.1Pt1A4PEFAGmFySlfVeFKZKuVCC-u_ZEW-KYQq-P57k");
      $info = json_decode($data, true);

      $clientes=Cliente::where('numero_documento',array($info['dni']))->first();
      if (isset($clientes)) {
        $ruc_view=$clientes->numero_documento;
        $ifexiste='1';/*Existe*/
        $datos = array(
          0 => array($dni),
          1 => array($clientes->empresa),
          2 => 'existente',
        );
        return json_encode($datos);
      }
      else{
        $ruc_view=array($info['dni']);
      }

      $datos = array(
        0 => $dni,
        1 => $info['dni'],
        2 => $info['nombres'],
        3 => $info['apellidoPaterno'],
        4 => $info['apellidoMaterno'],
      );
      return json_encode($datos);
    }
    
  }
