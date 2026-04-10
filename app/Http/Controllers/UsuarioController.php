<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Config;
use App\Permiso;
use App\Personal;
use App\User;
use App\Empresa;
use Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;
use Spatie\Permission\Traits\HasRoles;
use Swift_SmtpTransport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $usuarios=User::where('id','!=',1)->get();
        $usuarios = User::where('id', '!=', 1)->get();
        $almacen = Almacen::where('estado', 0)->get();
        $i = 1;
        $roles = Role::where('id', '!=', '1')->where('type', '!=', 1)->get();
        $personal = Personal::where('usuario_registrado', 0)->where('estado', 1)->get();
        // return view('configuracion_general.usuario.index',compact('usuarios','almacen','i'));
        // return $personal;
        return view('configuracion_general.usuario.index', compact('usuarios', 'almacen', 'i', 'roles', 'personal'));
    }
    public function index_usuarios()
    {
        // $usuarios=User::where('id','!=',1)->get();
        $usuarios = User::where('id', '!=', 1)->get();
        $almacen = Almacen::where('estado', 0)->get();
        $i = 1;
        $roles = Role::get();
        foreach ($roles as $role) {
            $role->permissions;
        }

        $permisos = Permission::get();
        // return [$roles, $permisos];
        // return view('configuracion_general.usuario.index',compact('usuarios','almacen','i'));
        return view('configuracion_general.usuario.index', [
            "usuarios" => $usuarios,
            "almacen" => $almacen,
            'i' => $i,
            "roles" => $roles,
            "permisos" => $permisos
        ]);
        // return view('configuracion_general.usuario.index2',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista()
    {
        $almacen = Almacen::where('estado', '0')->get();
        $i = 1;
        $personales = Personal::where('usuario_registrado', 0)->where('estado', 1)->get();
        return view('configuracion_general.usuario.lista', compact('personales', 'almacen', 'i'));
    }


    // public function create()
    // {

    // }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'correo' => ['required', 'email', 'unique:users,email'],
        ], [
            'correo.unique' => 'Hubo un error, el correo ya está en uso en el Sistema',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('warning', $validator->errors()->first()) // aquí tu mensaje personalizado
                ->withInput();
        }

        // return $request;
        $datos = $request;
        $almacen = Almacen::where('estado', 0)->get();
        $i = 1;
        $personal = Personal::findorFail($request->persona_id);
        $rol = Role::find($request->rol_id);
        $roles = Role::whereNotIn('id', [1, 4])->where('type', 0)->get();
        $permisos = Permission::orderBy('id')
            ->get()
            ->groupBy('module') // nivel 1
            ->map(function ($grupo) {
                return $grupo->groupBy(function ($permiso) {
                    return explode('.', $permiso->name)[0]; // nivel 2
                });
            });
        // return $personal->id;
        if ($request->rol_id == 4) { // Rol Personalizado
            // Se debe crear un "Rol Personalizado, diferente de los demas " 
            return view('configuracion_general.usuario.add_permisos_user', compact('datos', 'almacen', 'personal', 'rol', 'permisos', 'roles'));
        } else {
            if ($request->hasfile('avatar')) {
                $image1 = $request->file('avatar');
                $avatar = time() . $image1->getClientOriginalName();
                $destinationPath = public_path('/profile/images/');
                $image1->move($destinationPath, $avatar);
            } else {
                $avatar = 'defecto.jpg';
            }

            if ($datos->almacen_id != "todos") {
                $almacen_selec = $datos->almacen_id;
            }

            $apariencia = Config::default_config();
            $codigo = User::codigo_mensaje();

            $user = new User();
            $user->personal_id = $personal->id;
            $user->confi_id = $apariencia->id;
            $user->name = $personal->full_name;
            $user->email = $datos->correo;
            $user->celular = $personal->celular ?? NULL;
            $user->password = bcrypt($datos->password);
            $user->almacen_id = $almacen_selec ?? NULL; // NULL = TODOS
            $user->numero_validacion = $codigo;
            $user->estado_validacion = 0;
            $user->estado = 0;
            $user->email_creado = 0;
            $user->avatar = $avatar;
            $user->save();
            // Envio de Codigo por Correo:
            $send_mail = User::send_mail_register($user, $datos->correo);
            User::updated_personal($personal->id);

            // Asignacion de Permisos
            $user->assignRole($datos->rol_id);
            // return $send_mail;
            if ($send_mail == "200") {
                $msg = "Se envió un código a " . $datos->correo . ', digitarlo para activar al usuario en el sistema';
                return redirect()->back()->with('success', $msg);
            } else {
                $msg = "Hubo problema al enviar el codigo a " . $datos->correo . ', verificar el correo o contactar a Soporte';
                return redirect()->back()->with('warning', $msg);
            }
        }
        // $id = $request->persona_id;
        // $personal=Personal::find($id);
        // // Funcion para enviar el correo 
        // $msg = "Se envió un código a ".$request->correo.', digitarlo para activar al usuario en el sistema';
        // return redirect()->back()->with('success',$msg)->with('id_user', $request);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function permiso_personalizado(Request $request)
    {
        //Al no poder recibir 2 parametros,obliga a la creacion de otro 
        return $request;
    }


    // public function creacion(Request $request, $id)
    // {
    //     $this->validate($request, [
    //         'correo' => ['required', 'email', 'unique:users,email'],
    //     ], [
    //         'email.unique' => 'El correo ya existe',
    //     ]);

    //     $data = $request->all();
    //     // recibiendo Datos
    //     $usuarios = User::where('id', '!=', 1)->get();
    //     $name = $request->get('name');
    //     $email = $request->get('correo');
    //     $celular = $request->get('celular');
    //     $almacen_id = $request->get('almacen_id');
    //     $password = $request->get('password');
    //     $password_2 = $request->get('password_2');


    //     if ($password_2 == $password) {
    //         /*Apariencia de su interfaz*/
    //         $apariencia = new Config();
    //         $apariencia->fondo_perfil = 'paisaje_noche.jpg';
    //         $apariencia->borde_foto = "3px";
    //         $apariencia->color_borde_foto = '#ffffff';
    //         $apariencia->foto_icono = "defecto.png";
    //         $apariencia->foto_perfil = "0";
    //         $apariencia->letra = "none";
    //         $apariencia->tamano_letra = " ";
    //         $apariencia->color_sombra_nombre = "#000000 ";
    //         $apariencia->color_nombre = "#ffffff ";
    //         $apariencia->tamano_letra_perfil = "12px ";
    //         $apariencia->save();



    //         /*Creacion del Nuevo Usuario*/
    //         $user = new User();
    //         $user->personal_id = $id;
    //         $user->confi_id = $apariencia->id;
    //         $user->name = $name;
    //         $user->email = $email;
    //         $user->celular = $celular;
    //         $user->password = bcrypt($password);
    //         $user->almacen_id = $almacen_id;
    //         $user->numero_validacion = $numero_validacion;
    //         $user->estado_validacion = 0;
    //         $user->estado = 0;
    //         $user->email_creado = 0;
    //         $user->avatar = $avatar;
    //         //asignacion de rol automatico
    //         $user->assignRole('Admin');
    //         //
    //         $user->save();
    //         $empresa = Empresa::first();
    //         $empresa_name = Empresa::pluck('nombre')->first();
    //         $user = Personal::find($id);
    //         $user->usuario_registrado = 1;
    //         $user->save();
    //         $usuario_hora = Carbon::now()->format('Y-m-d');

    //         $nombre_personal = Personal::where('id', $id)->pluck('nombres')->first();
    //         // $codigo_mensaje=$numero_validacion;
    //         // $codigo_1 = substr($codigo_mensaje, 0, 3);
    //         // $codigo_2 = substr($codigo_mensaje, 3, 3);
    //         // $codigo_3 = substr($codigo_mensaje, 6, 3);
    //         // $codigo_unidos=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */
    //         $cuerpo_mensaje  = view('email_html.email_cod_confirmacion', compact('codigo_unidos', 'nombre_personal', 'usuario_hora', 'empresa'));
    //         /* envio*/
    //         /* Confi*/
    //         $smtpAddress = env('MAIL_HOST');
    //         $port = env('MAIL_PORT');
    //         $encryption = env('MAIL_ENCRYPTION');
    //         $yourEmail = env('MAIL_USERNAME');
    //         $yourPassword = env('MAIL_PASSWORD');
    //         $sendto = $email;
    //         $titulo = 'Sistema-Codigo Confirmacion';
    //         $mensaje = $cuerpo_mensaje;
    //         // $bakcup=    $correo_busqueda->email_backup ;
    //         /*Fin Confi*/
    //         $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption))->setUsername($yourEmail)->setPassword($yourPassword);
    //         $mailer = new \Swift_Mailer($transport);
    //         $message = (new \Swift_Message($titulo))->setFrom([$yourEmail => $empresa->nombre])->setTo([$sendto])->setBody($mensaje, 'text/html');
    //         if ($mailer->send($message)) {
    //             return redirect()->route('usuarios.index');
    //         } else {
    //             return "Something went wrong :(";
    //         }
    //         /*fin envio*/

    //         return redirect()->route('usuarios.index');
    //     } else {
    //         $i = 1;
    //         $almacen = Almacen::all();
    //         $errores = 'Las Contraseñas No Coinciden, Intentelo nuevamente';
    //         $personales = Personal::where('usuario_registrado', 0)->get();
    //         return view('configuracion_general.usuario.lista', compact('personales', 'errores', 'almacen', 'i'));
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $roles = Role::where('id', '!=', '1')->where('type', '!=', 1)->get();
        $almacen = Almacen::where('estado', 0)->get();
        $permisos = Permission::orderBy('id')
            ->get()
            ->groupBy('module') // nivel 1
            ->map(function ($grupo) {
                return $grupo->groupBy(function ($permiso) {
                    return explode('.', $permiso->name)[0]; // nivel 2
                });
            });
        $permisosRol = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        return view('configuracion_general.usuario.show', compact('user', 'almacen', 'roles', 'permisos', 'permisosRol'));
    }

    public function perfil()
    {
        // $usuarios=User::where('id','!=',1)->get();
        $usuarios = User::where('id', '!=', 1)->get();
        $almacen = Almacen::where('estado', 0)->get();
        $i = 1;
        $roles = Role::where('id', '!=', '1')->get();
        $personal = Personal::where('usuario_registrado', 0)->where('estado', 1)->get();
        // return view('configuracion_general.usuario.index',compact('usuarios','almacen','i'));
        // return $personal;

        return view('configuracion_general.usuario.perfil', compact('usuarios', 'roles', 'personal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        return view('configuracion_general.usuario.edit', compact('usuario'));
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
        // Se editan los datos del perfil y el rol asignado

        $user = User::findOrFail($id);
        $user->update([
            'name'        => $request->user_name,
            'email'       => $request->correo,
            'celular'     => $request->celular,
            'almacen_id'  => $request->almacen_id != "todos" ? $request->almacen_id : null,
            'email_user'  => $request->correo_legal,
            'nombre'      => $request->nombre_legal,
            'estado'      => $request->estado === 'on' ? 1 : 0,
        ]);

        $rolActualNombre = $user->getRoleNames()->first();
        $rolActual = $rolActualNombre ? Role::findByName($rolActualNombre) : null;
        $user->syncRoles([]);

        if ($request->rol_actual != 4) {
            if ($rolActual && $rolActual->type == 1) {
                if ($rolActual->users()->count() <= 1) {
                    $rolActual->delete();
                }
            }
            $user->assignRole($request->rol_actual);
        }else {

            $permisos = $request->permissions ?? [];
            $permisosValidos = Permission::whereIn('name', $permisos)->get();

            if ($rolActual && $rolActual->type == 1) {

                $rolActual->syncPermissions($permisosValidos);
                $user->assignRole($rolActual->name);
            } else {

                $rolNuevo = Role::create([
                    'name' => 'user_' . $user->id . '_custom',
                    'guard_name' => 'web',
                    'type' => 1
                ]);

                $rolNuevo->syncPermissions($permisosValidos);
                $user->assignRole($rolNuevo->name);
            }
        }

        return redirect()->back()->with('success', "El Usuario se modificó correctamente");

        $btn = $request->get('btn');
        if (isset($btn)) {
            $password = $request->get('password');
            if ($request->hasfile('avatar')) {
                $image1 = $request->file('avatar');
                $avatar = time() . 'profile';
                $destinationPath = public_path('/profile/images/');
                $image1->move($destinationPath, $avatar);
            } else {
                $avatar = $request->get('avatar_respaldo');
            }
            $user = User::find($id);
            $user->nombre = $request->get('nombre');
            $user->email_user = $request->get('email_user');
            $user->celular = $request->get('celular');
            if (isset($password)) {
                $user->password = bcrypt($password);
            }
            $user->avatar = $avatar;
            $user->save();
            return redirect()->route('usuario.index');
        }
        // return $request->file('avatar');
        $numero_validacion = rand(600000000, 900000000);
        $nombre_personal = Personal::where('id', $id)->first();
        $usuario_id = User::where('id', $id)->first();
        $usuarios = User::where('id', '!=', 1)->get();
        $almacen = Almacen::all();
        $celular = $request->get('celular');
        $contrasena_confirmar = $request->get('contrasena_confirmar');
        $correo_new = $request->get('correo');

        $password_new = $request->get('password_new');
        $contrasena_adm = $request->get('contrasena_adm');
        $almacen_id = $request->get('almacen_id');
        $estado = $request->get('estado');
        if ($estado == 'on') {
            $estado_numero = '1';
        } else {
            $estado_numero = '0';
        }
        if (isset($password_new)) {
            $password = bcrypt($password_new);
        } else {
            $password = $usuario_id->password;
        }

        if (password_verify($contrasena_confirmar, $contrasena_adm)) {
            if ($correo_new != $usuario_id->email) {
                $this->validate($request, [
                    'correo' => ['required', 'email', 'unique:users,email'],
                ], [
                    'correo.unique' => 'El Correo "' . $correo_new . '" ya esta Registrado, Use otro correo para registrar este usuario.',
                ]);

                $data = $request->all();

                if ($request->hasfile('avatar')) {
                    $image1 = $request->file('avatar');
                    $avatar = time() . $image1->getClientOriginalName();
                    $destinationPath = public_path('/profile/images/');
                    $image1->move($destinationPath, $avatar);
                } else {
                    $avatar = 'defecto.jpg';
                }

                $user = User::find($id);
                $user->email = $correo_new;
                $user->estado_validacion = '0';
                $user->estado = '0';
                $user->numero_validacion = $numero_validacion;
                $user->save();

                $codigo_mensaje = $numero_validacion;
                $usuario_hora = Carbon::now()->format('Y-m-d');
                $codigo_1 = substr($codigo_mensaje, 0, 3);
                $codigo_2 = substr($codigo_mensaje, 3, 3);
                $codigo_3 = substr($codigo_mensaje, 6, 3);
                $codigo_unidos = $codigo_1 . '-' . $codigo_2 . '-' . $codigo_3;/*Codigo unido */
                $cuerpo_mensaje = view('email_html.email_cod_confirmacion', compact('codigo_unidos', 'nombre_personal', 'usuario_hora', 'empresa'));

                $smtpAddress = env('MAIL_HOST');
                $port = env('MAIL_PORT');
                $encryption = env('MAIL_ENCRYPTION');
                $yourEmail = env('MAIL_USERNAME');
                $yourPassword = env('MAIL_PASSWORD');
                $sendto = $correo_new;
                $titulo = 'Sistema-Codigo Confirmacion';
                $mensaje = $cuerpo_mensaje;
                // $bakcup=    $correo_busqueda->email_backup ;
                /*Fin Confi*/
                $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption))->setUsername($yourEmail)->setPassword($yourPassword);
                $mailer = new \Swift_Mailer($transport);
                $message = (new \Swift_Message($yourEmail))->setFrom([$yourEmail => $titulo])->setTo([$sendto])->setBody($mensaje, 'text/html');
                if ($mailer->send($message)) {
                    return redirect()->route('usuario.index');
                } else {
                    return "Something went wrong :(";
                }
                /*fin envio*/
                return redirect()->route('usuarios.index');
            } else {
                if ($request->hasfile('avatar')) {
                    $image1 = $request->file('avatar');
                    $avatar = time() . $image1->getClientOriginalName();
                    $destinationPath = public_path('/profile/images/');
                    $image1->move($destinationPath, $avatar);
                } else {
                    $avatar = 'defecto.png';
                }


                $user = User::find($id);
                $user->almacen_id = $almacen_id;
                $user->estado = $estado_numero;
                $user->save();
                return redirect()->route('usuarios.index');
            }
        } else {
            $errores = 'Contraseña delAdministrador Erronea - Ningun Cambio Realizado';
            $i = 1;
            return view('configuracion_general.usuario.index', compact('usuarios', 'errores', 'almacen', 'i'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function codigo_nuevo_correo(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'correo' => ['required', 'email', 'unique:users,email'],
        ], [
            'correo.unique' => 'Hubo un error, el correo ya está en uso en el Sistema',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => "El correo digitado ya está en uso por el sistema, cambiar el correo por favor"
            ]);
        }


        $user = User::find($id);
        $user->email = $request->correo;
        $user->save();

        $codigo = User::codigo_mensaje();
        $send_mail = User::send_mail_register($user, $request->correo);
        $user->numero_validacion = $codigo;
        $user->save();

        if ($send_mail == "200") {
            $msg = "Se envió un código a " . $user->email . ", digitarlo para activar al usuario en el sistema";
            return response()->json([
                'status' => 'success',
                'message' => $msg
            ]);
        } else {
            $msg = "Hubo problema al enviar el codigo a " . $user->email . ", verificar el correo o contactar a Soporte";
            return response()->json([
                'status' => 'danger',
                'message' => $msg
            ]);
        }
    }

    public function validar_cuenta(Request $request)
    {
        $id = $request->id_user;
        $user = User::find($id);


        $cod_1 = $request->get('cod_1');
        $cod_2 = $request->get('cod_2');
        $cod_3 = $request->get('cod_3');
        $codigo_validacion = $cod_1 . $cod_2 . $cod_3;
        $codigo_usuario = $user->numero_validacion;

        // Normalizar (solo números)
        $codigo_validacion = preg_replace('/\D/', '', $codigo_validacion);
        $codigo_usuario = preg_replace('/\D/', '', $codigo_usuario);
        // return $codigo_validacion;
        if ($codigo_validacion === $codigo_usuario) {
            $user->estado_validacion = '1';
            $user->estado = '1';
            $user->save();
            return redirect()->back()->with('success', "Codigo validado correctamente, el usuario ya puede acceder al sistema");
        } else {
            return redirect()->back()->with('error', "Codigo de validacion incorrecto");
        }
    }

    public function change_password(Request $request)
    {
        // return $request;
        $checkbox = $request->enviar_correo;
        $id = $request->id_user_change;

        if ($request->change_password != $request->change_password2) {
            return redirect()->back()->with('error', "Las contraseñas no son iguales");
        }

        $user = User::find($id);
        $user->password = bcrypt($request->change_password);
        $user->save();

        if ($checkbox == "on") {
            // Se envia el Correo
            User::send_mail_change_password($user, $user->email);
            return redirect()->back()->with('success', "Se cambió la contraseña correctamente, y adicional se envió un correo con la contraseña");
        } else {
            return redirect()->back()->with('success', "Se cambió la contraseña correctamente");
        }
    }

    public function permiso($id)
    {

        $usuario = User::find($id);
        $user = User::where('id', $id)->pluck('id')->first();
        $permisos = Permiso::all();

        // $hola = $user->hasPermissionTo('inicio');
        return view('configuracion_general.usuario.permisos.lista', compact('usuario', 'permisos', 'user'));

        // return $hola;
    }

    public function asignar_permiso(Request $request, $id)
    {
        //asignamiento de permisos
        $permisos = $request->get('permisos');
        $user = User::find($id);
        $user->givePermissionTo($permisos);
        $user->save();

        return  back();
    }
    public function delegar_permiso(Request $request, $id)
    {
        //asignamiento de permisos
        $permisos = $request->get('permisos');
        $user = User::find($id);
        $user->revokePermissionTo($permisos);
        $user->save();

        return  back();
    }
}
