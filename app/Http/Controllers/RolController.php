<?php

namespace App\Http\Controllers;

use App\Permiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Roles;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function gestionarRol($rol_id)
{
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
    $permisos = Permission::orderBy('name', 'asc')->get();

    // return [
    //     "rol" => $rol,
    //     "permisos" => $permisos,
    // ];

    return view('configuracion_general.rol.gestionarRol', [
        "rol" => $rol,
        "permisos" => $permisos,
    ]);
}


    public function gestionarRolOld($rol_id){
        $rol = Role::findOrFail($rol_id);
        $rol->permisos = $rol->permissions()->orderBy('name', 'asc')->get();
        //Si el nombre del permiso extiende un permiso "padre" entonces entra en su coleccion
        /*
            {
                rol{
                    permisos: [
                            {
                            "id": 122,
                            "name": "auxiliares",
                            "guard_name": "web",
                            "created_at": "2021-11-16T17:42:35.000000Z",
                            "updated_at": "2021-11-16T17:42:35.000000Z",
                            "pivot": {
                            "role_id": 1,
                            "permission_id": 122
                            },
                            "sub_permisos":[
                                {
                                "id": 124,
                                "name": "auxiliares-clientes.create",
                                "guard_name": "web",
                                "created_at": "2021-11-16T17:42:35.000000Z",
                                "updated_at": "2021-11-16T17:42:35.000000Z",
                                "pivot": {
                                "role_id": 1,
                                "permission_id": 124
                                }
                                },
                                {
                                "id": 129,
                                "name": "auxiliares-clientes.destroy",
                                "guard_name": "web",
                                "created_at": "2021-11-16T17:42:35.000000Z",
                                "updated_at": "2021-11-16T17:42:35.000000Z",
                                "pivot": {
                                "role_id": 1,
                                "permission_id": 129
                                }
                                },
                                {
                                "id": 127,
                                "name": "auxiliares-clientes.edit",
                                "guard_name": "web",
                                "created_at": "2021-11-16T17:42:35.000000Z",
                                "updated_at": "2021-11-16T17:42:35.000000Z",
                                "pivot": {
                                "role_id": 1,
                                "permission_id": 127
                                }
                                },
                            ],
                            "hasSubPermisos": true,
                            },
                        ]
                    }
                    
            }
        */
        $permisos = Permission::orderBy('name', 'asc')->get();
        return $rol;
        return view('configuracion_general.rol.gestionarRol', [
            "rol" => $rol, 
            "permisos" => $permisos,
        ]);

    }

}
