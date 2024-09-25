<?php

namespace App\Http\Controllers;

use App\Permiso;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Roles;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function gestionarRol($rol_id)
    {

        $access = ParameterCallController::verifyPermissionAccess(['admin-access']);

        if(!$access){
            return redirect()->route('inicio')->with('error', 'No tiene permisos para ejecutar esa acción.');
        }

        $rol = Role::findOrFail($rol_id);
        $permisosRol = $rol->permissions()->orderBy('name', 'asc')->get();

        $permisosAgrupados = [];
        foreach ($permisosRol as $permiso) {
            $esSubPermiso = false;

            foreach ($permisosAgrupados as $key => &$permisoBase) {
                // Verificar si el nombre del permiso comienza con el nombre del permiso base
                if (strpos($permiso->name, $permisoBase['permiso']->name) === 0 && $permiso->name !== $permisoBase['permiso']->name) {
                    // Agregar el subpermiso
                    $permisoBase['sub_permisos'][] = $permiso;
                    $permisoBase['hasSubPermisos'] = true;
                    $esSubPermiso = true;
                    break; // Salir del bucle una vez encontrado el padre
                }
            }

            // Si no es subpermiso, es un permiso base
            if (!$esSubPermiso) {
                $permisosAgrupados[$permiso->name] = [
                    'permiso' => $permiso,
                    'sub_permisos' => [],
                    'hasSubPermisos' => false
                ];
            }
        }

        $rol->permisos = $permisosAgrupados;
        $rol->permisosCount = count($permisosRol);
        $permisos = Permission::whereNotIn('id', $permisosRol->pluck('id'))->orderBy('name', 'asc')->get();

        // return ["rol" => $rol, "permisos" => $permisos,];

        return view('configuracion_general.rol.gestionarRol', [
            "rol" => $rol,
            "permisos" => $permisos,
        ]);
    }


    public function asignarPermisos(Request $request, $rol_id)
    {
        DB::beginTransaction();
        try {
            //Buscar rol
            $rol = Role::findOrFail($rol_id);

            if ($rol) {
                $permisosRol = $rol->permissions;
                $permisosRolId = $permisosRol->pluck('id')->toArray();
                $permisos_id = $request->permisos_id;
                //recorrer los permisos dados
                foreach ($permisos_id as $permiso_id) {
                    //buscar el permiso
                    $permiso = Permission::findOrFail($permiso_id);
                    if ($permiso) {
                        // verificar si el rol ya tiene este permiso o no
                        if (!in_array($permiso_id, $permisosRolId)) {
                            //Si no lo tiene se le agrega
                            $rol->givePermissionTo($permiso);
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('roles.gestRol', $rol_id)->with('success', 'Permiso(s) asignados correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.gestRol', $rol_id)->with('error', 'Ocurrió un error');
        }
    }

    public function removerPermiso($rol_id, $permiso_id)
    {
        DB::beginTransaction();
        try {
            //Buscar rol
            $rol = Role::findOrFail($rol_id);

            if ($rol) {
                $permisosRol = $rol->permissions;
                $permisosRolId = $permisosRol->pluck('id')->toArray();
                //buscar el permiso
                $permiso = Permission::findOrFail($permiso_id);
                if ($permiso) {
                    // verificar si el rol lo tiene
                    if (in_array($permiso_id, $permisosRolId)) {
                        //Si lo tiene se remueve
                        $rol->revokePermissionTo($permiso);
                    }
                }
            }
            DB::commit();
            return redirect()->route('roles.gestRol', $rol_id)->with('success', 'Permiso removido correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.gestRol', $rol_id)->with('error', 'Ocurrió un error');
        }
    }

    public function removerPermisos(Request $request, $rol_id)
    {
        // return $request;
        DB::beginTransaction();
        try {
            //Buscar rol
            $rol = Role::findOrFail($rol_id);

            if ($rol) {
                $permisosRol = $rol->permissions;
                $permisosRolId = $permisosRol->pluck('id')->toArray();
                // $permisos_id = explode(',', $request->permisos_id[0]);
                $permisos_id = json_decode($request->permisos_id, true);

                //recorrer los permisos dados
                foreach ($permisos_id as $permiso_id) {
                    // return $permisos_id;
                    //buscar el permiso
                    $permiso = Permission::findOrFail($permiso_id);
                    if ($permiso) {
                        // verificar si el rol lo tiene
                        if (in_array($permiso_id, $permisosRolId)) {
                        //Si lo tiene se remueve
                        $rol->revokePermissionTo($permiso);
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('roles.gestRol', $rol_id)->with('success', 'Permiso(s) removidos correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            // return $e;
            return redirect()->route('roles.gestRol', $rol_id)->with('error', 'Ocurrió un error');
        }
    }

}
