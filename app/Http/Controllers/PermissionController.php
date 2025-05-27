<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionEditRequest;
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

    public function create()
    {
        abort_if(Gate::denies('permission_create'), 403);
        return view('back.permissions.create');
    }


    public function store(PermissionCreateRequest $request)
    {
        Permission::create($request->only('name'));

        return redirect()->route('permissions.index')->with('success', 'Permiso creado correctamente!.');
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), 403);
        return view('back.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), 403);
        return view('back.permissions.edit', compact('permission'));
    }

    public function update(PermissionEditRequest $request, Permission $permission)
    {
        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')->with('success', 'El permiso ha sido actualizado correctamente!');
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_destroy'), 403);
        $permission->delete();
        return back()->with('success', 'Permiso eliminado correctamente!.');
    }
}
