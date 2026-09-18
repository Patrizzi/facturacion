<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Cliente;
use App\ClienteRetenedores;
use App\Cliente_sucursal;
use App\ComprobantesVentas;
use App\Contacto;
use App\Forma_pago;
use App\Personal_venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $clientes = Cliente::all();
        $contactos = Contacto::all();
        foreach ($clientes as  $cliente) {
            if ($cliente->empresa == null) {
                $cliente = Cliente::find($cliente->id);
                $cliente->empresa = $cliente->nombre;
                $cliente->save();
            }
        }
        return view('auxiliar.cliente.index', compact('clientes', 'contactos'));
    }

    public function ventas_index()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_ventas = ComprobantesVentas::count_month_ventas($mes_año);

        $almacen = Almacen::get();

        $count_all_ventas = ComprobantesVentas::count_day_ventas();
        return view('transaccion.venta.clientes.index', compact('almacen', 'count_all_ventas', 'count_month_ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::all();
        return view('auxiliar.cliente.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $documento_identificacion = $request->get('numero_documento');
        if (strstr($documento_identificacion, ' ', true) == true) {
            $doc_ruc = strstr($documento_identificacion, ' ', true);
            // return "1";
        } else {
            $doc_ruc = $documento_identificacion;
            // return "2";
        }
        $cliente_existe = Cliente::where('numero_documento', $doc_ruc)->count();

        if ($cliente_existe == 1) {
            return redirect()->route('cliente.index')->withErrors(['Cliente ya Agregado!']);
        } else {
            $cliente = new Cliente;
            $cliente->nombre = $request->get('nombre');
            $cliente->direccion = $request->get('direccion');
            $cliente->email = $request->get('email');
            $cliente->telefono = $request->get('telefono');
            $cliente->celular = $request->get('celular');
            $cliente->documento_identificacion = $request->get('documento_identificacion');
            $cliente->empresa = $request->get('nombre');
            $cliente->numero_documento = $request->get('numero_documento');
            $cliente->ciudad = $request->get('ciudad');
            $cliente->departamento = $request->get('departamento');
            $cliente->pais = $request->get('pais');
            $cliente->tipo_cliente = $request->get('tipo_cliente');
            $cliente->aniversario = $request->get('aniversario');
            /*Nota: el cod postal es código de UBIGEO, cuando se registra el cliente por el agre. rapido es Ubigeo, para envio a sunat es UBIGEO */
            $cliente->cod_postal = $request->get('cod_postal');
            $cliente->fecha_registro = $request->get('fecha_registro');
            $cliente->vendedor_id = $request->get('vendedor_id') ?? null;
            $cliente->forma_pago_id = $request->get('forma_pago_id') ?? null;
            $cliente->save();

            $contacto = new Contacto;
            $contacto->nombre = $request->get('nombre_contacto');
            $contacto->primer_contacto = 1;
            $contacto->cargo = $request->get('cargo_contacto');
            $contacto->telefono = $request->get('telefono_contacto');
            $contacto->celular = $request->get('celular_contacto');
            $contacto->email = $request->get('email_contacto');
            $contacto->clientes_id = $cliente->id;
            $contacto->save();
            return redirect()->route('cliente.show', $cliente->id);
        }
    }
    public function storecontact($data) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $cliente_show = Cliente::find($id);
        if (request()->wantsJson()) {
            return response()->json($cliente_show);
        }
        $cliente_rete = ClienteRetenedores::where('cliente_id', $id)->first();
        $cliente_sucursal = Cliente_sucursal::where('cliente_id', $id)->get();
        $contacto_show = Contacto::where('clientes_id', '=', $id)->orderBy('primer_contacto', 'DESC')->get();
        $contacto_cantidad = Contacto::where('clientes_id', $id)->count();
        $contacto_cantidad_estado = Contacto::where('clientes_id', $id)->where('estado', 0)->count();
        Cliente::revision_contacto($id);
        $vendedores = $personal = Personal_venta::with('personal.personal_l')->where('estado', 0)->get();
        $forma_pago = Forma_pago::get();
        return view('auxiliar.cliente.show', compact('cliente_show', 'contacto_show', 'contacto_cantidad', 'contacto_cantidad_estado', 'cliente_rete', 'cliente_sucursal', 'vendedores', 'forma_pago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);
        return view('auxiliar.cliente.edit', compact('cliente'));
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
        $cliente = Cliente::find($id);
        $cliente->nombre = $request->get('nombre');
        $cliente->direccion = $request->get('direccion');
        $cliente->email = $request->get('email');
        $cliente->telefono = $request->get('telefono');
        $cliente->anexo = $request->get('anexo');
        $cliente->celular = $request->get('celular');
        $cliente->empresa = $request->get('empresa');
        $cliente->documento_identificacion = $request->get('documento_identificacion');
        $cliente->numero_documento = $request->get('numero_documento');
        $cliente->ciudad = $request->get('ciudad');
        $cliente->departamento = $request->get('departamento');
        $cliente->pais = $request->get('pais');
        $cliente->tipo_cliente = $request->get('tipo_cliente');
        $cliente->cod_postal = $request->get('ubigeo');
        $cliente->aniversario = $request->get('aniversario');
        $cliente->fecha_registro = $request->get('fecha_registro');
        $cliente->vendedor_id = $request->get('vendedor_id') ?? null;
        $cliente->forma_pago_id = $request->get('forma_pago_id') ?? null;

        $cliente->save();
        return redirect()->route('cliente.show', $cliente->id);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}

    function ruc(Request $request)
    {
        // return $request->get('ruc');
        $ruc = $request->get('ruc');

        $response = Http::timeout(10)
            ->get("http://jypsac.dyndns.org:7000/v1/ruc/{$ruc}", [
                'token' => 'rtjK4ZNT49MSvpfs08pY5oXu3DlX80FNlXZTPv5hXvXzGJk25JL'
            ]);

        if (!$response->ok()) {
            return response()->json([
                'error' => 'No se pudo conectar al API externo',
                'status' => $response->status()
            ], 500);
        }

        $info = $response->json();

        if (!isset($info['ruc'])) {
            return ['sin', 'data ruc'];
        }

        $clientes = Cliente::where('numero_documento', $info['ruc'])->first();

        if ($clientes) {
            return [
                [$ruc],
                [$clientes->empresa],
                'existente'
            ];
        }

        return [
            [$info['ruc']],
            $info['razonSocial'],
            $info['direccion'],
            $info['provincia'],
            $info['distrito'],
            $info['ubigeo'],
        ];
    }

    //* API PARA DNI *//
    function dni(Request $request)
    {
        $dni = $request->get('dni');
        
        $response = Http::timeout(10)
            ->get("http://jypsac.dyndns.org:7000/v1/dni/{$dni}", [
                'token' => 'rtjK4ZNT49MSvpfs08pY5oXu3DlX80FNlXZTPv5hXvXzGJk25JL'
            ]);

        if (!$response->ok()) {
            return response()->json([
                'error' => 'No se pudo conectar al API externo',
                'status' => $response->status()
            ], 500);
        }

        $info = $response->json();

        if (!isset($info['dni'])) {
            return ['sin', 'data DNI'];
        }

        $clientes = Cliente::where('numero_documento', $info['dni'])->first();
        if ($clientes) {
            return [
                [$dni],
                [$clientes->empresa],
                'existente'
            ];
        }

        return [
            [$info['dni']],
            $info['nombres'],
            $info['apellidoPaterno'],
            $info['apellidoMaterno'],
        ];
    }




    public function exportCliente()
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $clientes = Cliente::all();

        $maxSucursales = 0;
        foreach ($clientes as $cliente) {
            $clientSucur = Cliente_sucursal::where('cliente_id', $cliente->id)->get();
            if ($clientSucur->count() > $maxSucursales) {
                $maxSucursales = $clientSucur->count();
            }
        }

        $headers = [
            'Nombre',
            'Direccion',
            'Email',
            'Telefono',
            'Celular',
            'Empresa',
            'Doc. Identificacion',
            'Nro. Documento',
            'Ciudad',
            'Departamento',
            'Pais',
            'Tipo Cliente',
            'Codigo Postal',
            'Aniversario',
            'Fecha Registro',
            'Vendedor Asignado',
            'Forma de Pago'
        ];

        // Agregar headers de sucursales dinámicamente
        for ($i = 1; $i <= $maxSucursales; $i++) {
            $headers[] = 'Sucursal ' . $i;
        }

        $headers[] = 'Retenedor';

        $rows = [$headers];
        
        foreach ($clientes as $cliente) {
            $row = [
                $cliente->nombre,
                $cliente->direccion,
                $cliente->email,
                $cliente->telefono,
                $cliente->celular,
                $cliente->empresa,
                $cliente->documento_identificacion,
                $cliente->numero_documento,
                $cliente->ciudad,
                $cliente->departamento,
                $cliente->pais,
                $cliente->tipo_cliente,
                $cliente->cod_postal,
                $cliente->aniversario,
                $cliente->fecha_registro,
                $cliente->vendedor_asignado?->personal?->personal_l->nombres.' '.$cliente->vendedor_asignado?->personal?->personal_l->apellidos,
                $cliente->forma_pago?->id,
            ];

            $clientSucur = Cliente_sucursal::where('cliente_id', $cliente->id)->get();

            for ($i = 0; $i < $maxSucursales; $i++) {
                if (isset($clientSucur[$i])) {
                    $sucursal = $clientSucur[$i];
                    $direccionCompleta = implode(', ', array_filter([
                        $sucursal->direccion,
                        $sucursal->distrito,
                        $sucursal->provincia,
                        $sucursal->departamento,
                        $sucursal->pais
                    ]));
                    $row[] = $direccionCompleta;
                } else {
                    $row[] = '';
                }
            }

            // Obtener retenedor del cliente
            $clienteRetenedor = ClienteRetenedores::where('cliente_id', $cliente->id)->first();
            $row[] = $clienteRetenedor ? $clienteRetenedor->porcentaje . '%' : 'No';

            $rows[] = $row;
        }

        $export = new class($rows) implements FromArray, WithEvents {
            private $rows;

            public function __construct($rows)
            {
                $this->rows = $rows;
            }

            public function array(): array
            {
                return $this->rows;
            }

            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function (AfterSheet $event) {

                        foreach (range('A', 'Z') as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(true);
                        }

                        foreach (range('A', 'Z') as $letter1) {
                            foreach (range('A', 'Z') as $letter2) {
                                $column = $letter1 . $letter2;
                                try {
                                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                                } catch (\Exception $e) {
                                    break 2;
                                }
                            }
                        }
                        $headerRange = 'A1:' . $event->sheet->getHighestColumn() . '1';
                        $event->sheet->getStyle($headerRange)->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => 'FFFFFF']
                            ],
                            'fill' => [
                                'fillType' => 'solid',
                                'color' => ['rgb' => '4472C4']
                            ]
                        ]);
                    },
                ];
            }
        };

        $fecha = now('America/Lima')->format('d-m-Y');
        return Excel::download($export, 'Clientes_' . $fecha . '.xlsx');
    }

    public function exportCliente2()
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $clientes = Cliente::all();

        $maxSucursales = 0;
        foreach ($clientes as $cliente) {
            $clientSucur = Cliente_sucursal::where('cliente_id', $cliente->id)->get();
            if ($clientSucur->count() > $maxSucursales) {
                $maxSucursales = $clientSucur->count();
            }
        }

        $headers = [
            'Nombre',
            'Direccion',
            'Email',
            'Telefono',
            'Anexo',
            'Celular',
            'Empresa',
            'Doc. Identificacion',
            'Nro. Documento',
            'Ciudad',
            'Departamento',
            'Pais',
            'Tipo Cliente',
            'Codigo Postal',
            'Aniversario',
            'Fecha Registro',
            'Vendedor Asignado',
            'Forma de Pago'
        ];

        // Agregar headers de sucursales dinámicamente
        for ($i = 1; $i <= $maxSucursales; $i++) {
            $headers[] = 'Sucursal ' . $i;
        }

        $headers[] = 'Retenedor';

        $rows = [$headers];

        foreach ($clientes as $cliente) {
            $row = [
                $cliente->nombre,
                $cliente->direccion,
                $cliente->email,
                $cliente->telefono,
                $cliente->anexo,
                $cliente->celular,
                $cliente->empresa,
                $cliente->documento_identificacion,
                $cliente->numero_documento,
                $cliente->ciudad,
                $cliente->departamento,
                $cliente->pais,
                $cliente->tipo_cliente,
                $cliente->cod_postal,
                $cliente->aniversario,
                $cliente->fecha_registro,
                $cliente->vendedor_asignado?->personal?->personal_l->nombres.' '.$cliente->vendedor_asignado?->personal?->personal_l->apellidos,
                $cliente->forma_pago?->id,
            ];

            $clientSucur = Cliente_sucursal::where('cliente_id', $cliente->id)->get();

            for ($i = 0; $i < $maxSucursales; $i++) {
                if (isset($clientSucur[$i])) {
                    $sucursal = $clientSucur[$i];
                    $direccionCompleta = implode(', ', array_filter([
                        $sucursal->direccion,
                        $sucursal->distrito,
                        $sucursal->provincia,
                        $sucursal->departamento,
                        $sucursal->pais
                    ]));
                    $row[] = $direccionCompleta;
                } else {
                    $row[] = '';
                }
            }

            // Obtener retenedor del cliente
            $clienteRetenedor = ClienteRetenedores::where('cliente_id', $cliente->id)->first();
            $row[] = $clienteRetenedor ? $clienteRetenedor->porcentaje . '%' : 'No';

            $rows[] = $row;
        }

        $export = new class($rows) implements FromArray, WithEvents {
            private $rows;

            public function __construct($rows)
            {
                $this->rows = $rows;
            }

            public function array(): array
            {
                return $this->rows;
            }

            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function (AfterSheet $event) {
                        foreach (range('A', 'Z') as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(true);
                        }
                        foreach (range('A', 'Z') as $letter1) {
                            foreach (range('A', 'Z') as $letter2) {
                                $event->sheet->getColumnDimension($letter1 . $letter2)->setAutoSize(true);
                            }
                        }
                    },
                ];
            }
        };

        $fecha = now('America/Lima')->format('d-m-Y');
        return Excel::download($export, 'Clientes_' . $fecha . '.xlsx');
    }
}
