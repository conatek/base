<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleEditRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getRolesAndPermissionsData() {
        $results = [];

        $roles = Role::all();
        $permissions = Permission::with('module')->get()->groupBy(function ($permission) {
            return $permission->module->display_name ?? 'Sin módulo';
        });

        $rolePermissionsMap = [];
        foreach ($roles as $role) {
            $rolePermissionsMap[$role->name] = $role->permissions->pluck('name')->toArray();
        }

        $results['roles'] = $roles;
        $results['permissions'] = $permissions;
        $results['rolePermissionsMap'] = $rolePermissionsMap;

        return $results;
    }

    public function getRolesData() {
        $results = [];

        $roles = Role::all();

        $results['roles'] = $roles;

        return $results;
    }

    public function togglePermission(Request $request)
    {
        $role = Role::where('name', $request->role)->firstOrFail();
        $permission = Permission::where('name', $request->permission)->firstOrFail();

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
        } else {
            $role->givePermissionTo($permission);
        }

        return response()->json(['success' => true]);
    }

    public function index()
    {
        // abort_if(Gate::denies('role_index'), 403);


        return view('back.roles.index');
    }

    public function store(RoleCreateRequest $request)
    {
        // Las validaciones se realizan en RoleCreateRequest

        try{
            $data = array(
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            );

            Role::create($data);

            $roles = Role::all();

            return response()->json([
                'success' => true,
                'message'=>'Role creado exitosamente!',
                'roles'=>$roles,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(RoleEditRequest $request, Role $role)
    {
        $data = array(
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        );

        $role->update($data);

        $roles = Role::all();

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente!',
            'roles' => $roles,
        ]);
    }

    // public function destroy(Role $role)
    public function destroy($id)
    {
        // abort_if(Gate::denies('role_destroy'), 403);
        $role = Role::findOrFail($id);

        // Verificar si el rol tiene usuarios asignados
        if ($role->users()->count() > 0) {
            $roles = Role::all();

            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el rol porque tiene usuarios asignados.',
                'roles' => $roles,
            ]);
        }

        $role->delete();

        $roles = Role::all();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado correctamente!',
            'roles' => $roles,
        ]);
    }
}
