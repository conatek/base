<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleCreateRequest;
use App\Http\Requests\ModuleEditRequest;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function getModulesData() {
        $results = [];

        $modules = Module::all();

        $results['modules'] = $modules;

        return $results;
    }

    public function store(ModuleCreateRequest $request)
    {
        // Las validaciones se realizan en ModuleCreateRequest

        try{
            $data = array(
                'name' => $request->name,
                'display_name' => $request->display_name,
            );

            Module::create($data);

            $modules = Module::all();

            return response()->json([
                'success' => true,
                'message'=>'Módulo creado exitosamente!',
                'modules'=>$modules,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(ModuleEditRequest $request, Module $module)
    {
        $data = array(
            'name' => $request->name,
            'display_name' => $request->display_name,
        );

        $module->update($data);

        $modules = Module::all();

        return response()->json([
            'success' => true,
            'message' => 'Módulo actualizado correctamente!',
            'modules' => $modules,
        ]);
    }

    public function destroy($id)
    {
        // abort_if(Gate::denies('role_destroy'), 403);
        $module = Module::findOrFail($id);

        $module->delete();

        $modules = Module::all();

        return response()->json([
            'success' => true,
            'message' => 'Módulo eliminado correctamente!',
            'modules' => $modules,
        ]);
    }
}
