<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionEditRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_index'), 403);
        $permissions = Permission::all();
        return view('back.permissions.index', compact('permissions'));
    }

    public function store(PermissionCreateRequest $request)
    {
        // Las validaciones se realizan en PermissionCreateRequest

        try{
            $data = array(
                'name' => $request->name,
                'display_name' => $request->display_name,
                'module_id' => $request->module_id,
                'guard_name' => $request->guard_name,
            );

            Permission::create($data);

            $permissions = Permission::all();

            return response()->json([
                'success' => true,
                'message'=>'Permiso creado exitosamente!',
                'permissions'=>$permissions,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(PermissionEditRequest $request, Permission $permission)
    {
        // Las validaciones se realizan en PermissionEditRequest

        $data = array(
            'name' => $request->name,
            'display_name' => $request->display_name,
            'module_id' => $request->module_id,
            'guard_name' => $request->guard_name,
        );

        $permission->update($data);

        $permissions = Permission::all();

        return response()->json([
            'success' => true,
            'message' => 'Permiso actualizado correctamente!',
            'permissions' => $permissions,
        ]);
    }

    public function destroy($id)
    {
        // abort_if(Gate::denies('role_destroy'), 403);
        $permission = Permission::findOrFail($id);

        // Verificar si el permiso está asignado a un rol
        if ($permission->roles()->count() > 0) {

            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el permiso porque está asignado a un rol.',
            ]);
        }

        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permiso eliminado correctamente!',
        ]);
    }
}
