<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getRolesAndPermissionsData() {
        $results = [];

        $roles = Role::all();
        $permissions = Permission::all()->groupBy('module');

        $rolePermissionsMap = [];
        foreach ($roles as $role) {
            $rolePermissionsMap[$role->name] = $role->permissions->pluck('name')->toArray();
        }

        $results['roles'] = $roles;
        $results['permissions'] = $permissions;
        $results['rolePermissionsMap'] = $rolePermissionsMap;

        return $results;
    }

    public function togglePermission(Request $request)
    {
        // dd($request->all());

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

    public function create()
    {
        abort_if(Gate::denies('role_create'), 403);
        $permissions = Permission::all()->pluck('name', 'id');
        return view('back.roles.create', compact('permissions'));
    }

    public function store(RoleCreateRequest $request)
    {
        $role = Role::create($request->only('name'));

        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente!.');
    }

    public function show(Role $role)
    {
        // abort_if(Gate::denies('role_show'), 403);
        $role->load('permissions');
        return view('back.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        // abort_if(Gate::denies('role_edit'), 403);
        $permissions = Permission::all()->pluck('name', 'id');
        $role->load('permissions');
        return view('back.roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleEditRequest $request, Role $role)
    {
        $role->update($request->only('name'));

        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index')->with('success', 'El rol ha sido actualizado correctamente!');
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_destroy'), 403);
        $role->delete();
        return back()->with('success', 'Rol eliminado correctamente!.');
    }
}
