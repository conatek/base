<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Collaborator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserCreateRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function __construct()
    {
        // Aplicamos el middleware AJAX solo a métodos específicos
        $this->middleware(function ($request, $next) {
            if (!request()->ajax()) {
                abort(403, 'Acceso denegado');
            }
            return $next($request);
        })->except(['index']);

        $this->middleware('can:users_index')->only(['index']);
    }

    public function getUsers() {
        $user = Auth::user();
        $company_id = $user->company_id;

        // Obtenemos usuarios con roles
        $users = User::where('company_id', $company_id)
                    ->with(['roles'])
                    ->get();

        // Transformamos la colección para agregar el nombre completo concatenado
        $users->transform(function ($user) {
            $user->full_name = trim("{$user->name} {$user->first_surname} {$user->second_surname}");
            return $user;
        });

        return response()->json([
            'users' => $users
        ]);
    }

    public function getUserAdmin($company_id)
    {
        $user = User::where('company_id', $company_id)->with('roles')->whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$user) {
            return response()->json([
                'message' => 'No se encontró un administrador para esta empresa.',
                'user_admin' => null
            ]);
        }

        return response()->json([
            'user_admin' => $user
        ]);
    }

    public function index()
    {
        // abort_if(Gate::denies('user_index'), 403);
        $current_user_id = Auth::user()->id;
        $current_user_roles = Auth::user()->roles->pluck('name')->toArray();
        $company_id = Auth::user()->company_id;
        // $users = User::where('company_id', $company_id)->with(['company', 'roles'])->get();
        $roles = Role::all();


        return view('spa');

    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), 403);
        $companies = Company::all()->pluck('name', 'id');
        $roles = Role::all()->pluck('name', 'id');
        return view('back.users.create', compact('companies', 'roles'));
    }

    public function store(UserCreateRequest $request)
    // public function store(Request $request)
    {
        // Las validaciones se realizan en UserCreateRequest

        try {
            return DB::transaction(function () use ($request) {
                $image_public_id = null;
                $image_url = null;

                if($request->hasFile('image')) {
                    $file = request()->file('image');
                    $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
                        'folder' =>  'mh/' . env("APP_ENV", "local") . '/' . $request['company_id'] . '/users']
                    ); // => mh/local/1/users/qxrcxytjrwufqjij9ix3
                    $image_public_id = $cloudinary_object->getPublicId();
                    $image_url = $cloudinary_object->getSecurePath();
                }

                $user = User::create([
                    'company_id'      => $request->company_id,
                    'name'            => $request->name,           // "Juan"
                    'first_surname'   => $request->first_surname,  // "Perez"
                    'second_surname'  => $request->second_surname, // "Lopez" (o null)
                    'email'           => $request->email,
                    'password'        => bcrypt($request->input('password')),
                    'image_public_id' => $image_public_id,
                    'image_url'       => $image_url,
                ]);

                $user->syncRoles($request->input('roles', []));

                Collaborator::create([
                    'user_id'       => $user->id,
                    'company_id'    => $request->company_id,
                    'name'          => $request->name,
                    'first_surname' => $request->first_surname,
                    'second_surname'=> $request->second_surname,
                    'email'         => $request->email,
                    'is_active'     => 1, // El Admin nace activo
                    // Los demás campos (cédula, ciudad, etc) quedan NULL por ahora
                ]);

                return response()->json([
                    'message'=>'Usuario creado exitosamente',
                    'user'=>$user
                ]);
            });
        } catch (\Exception $e) {
            // Loguear error y retornar fallo
            Log::error('Error creando usuario admin: '.$e->getMessage());
            return response()->json(['message' => 'Error al crear el usuario', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), 403);
        $user->load('roles');
        return view('back.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // abort_if(Gate::denies('user_edit'), 403);

        $result = [];

        $company = Company::where('id', $user->company_id)->pluck('company_name', 'id');
        // $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');

        $result['company'] = $company;
        // $result['roles'] = $roles;
        $result['user'] = $user;

        return $result;
    }

    public function update(UserEditRequest $request, User $user)
    {
        try {
            return DB::transaction(function () use ($request, $user) {

                // 1. Preparar datos básicos
                $data = $request->only('name', 'first_surname', 'second_surname', 'email', 'company_id');

                // 2. Manejo de Contraseña (solo si se envía)
                if ($request->filled('password')) {
                    $data['password'] = bcrypt($request->input('password'));
                }

                // 3. Manejo de Imagen (Cloudinary)
                if ($request->hasFile('image')) {
                    // Eliminar anterior si existe
                    if ($user->image_public_id) {
                        Cloudinary::destroy($user->image_public_id);
                    }

                    $file = $request->file('image');
                    $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'mh/' . env("APP_ENV", "local") . '/' . $request->company_id . '/users'
                    ]);

                    $data['image_public_id'] = $cloudinary_object->getPublicId();
                    $data['image_url'] = $cloudinary_object->getSecurePath();
                }
                // Nota: Si no hay imagen nueva, no tocamos esos campos, User::update respeta los valores actuales
                // a menos que los pases explícitamente como null.

                // 4. Actualizar USUARIO
                $user->update($data);

                // 5. Actualizar ROLES
                $user->syncRoles($request->input('roles', []));

                // 6. Sincronizar COLABORADOR (Espejo)
                // Si el usuario tiene un colaborador asociado, actualizamos sus datos básicos
                if ($user->collaborator) {
                    $user->collaborator->update([
                        'name'           => $data['name'],
                        'first_surname'  => $data['first_surname'] ?? $user->collaborator->first_surname,
                        'second_surname' => $data['second_surname'] ?? $user->collaborator->second_surname,
                        'email'          => $data['email'],
                        // No actualizamos company_id ni otros datos sensibles del colaborador aquí, solo identidad.
                    ]);
                }

                return response()->json([
                    'message' => 'Usuario actualizado exitosamente!',
                    'user'    => $user
                ]);

            }); // Fin Transacción

        } catch (\Exception $e) {
            Log::error('Error actualizando usuario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al actualizar el usuario.',
                'error'   => $e->getMessage() // Ocultar en producción
            ], 500);
        }
    }

    public function destroy($user_id)
    {
        // abort_if(Gate::denies('user_destroy'), 403);

        try {
            $user = User::where('id', $user_id)->first();
            if(isset($user['image_public_id'])) {
                $public_id = $user['image_public_id'];
                Cloudinary::destroy($public_id);
            }

            $user->delete();

            return response()->json([
                'message'=>'Usuario eliminado exitosamente!',
                'user'=>$user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
