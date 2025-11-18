<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\AfpType;
use App\Models\ArlType;
use App\Models\CcfType;
use App\Models\EpsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CollaboratorSocialSecurity;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Requests\CollaboratorSocialSecurityEditRequest;
use App\Http\Requests\CollaboratorSocialSecurityCreateRequest;

class CollaboratorSocialSecurityController extends Controller
{
    public function getSocialSecurityInformation()
    {
        $results = [];

        $eps_types = EpsType::all();
        $arl_types = ArlType::all();
        $afp_types = AfpType::all();
        $ccf_types = CcfType::all();

        $results['eps_types'] = $eps_types;
        $results['arl_types'] = $arl_types;
        $results['afp_types'] = $afp_types;
        $results['ccf_types'] = $ccf_types;

        return $results;
    }

    public function getSocialSecurityByCollaborator($collaborator_id)
    {
        $results = [];

        $social_security = CollaboratorSocialSecurity::where('collaborator_id', $collaborator_id)
            ->with([
                'eps',
                'afp_pension',
                'afp_saving',
                'arl',
                'ccf'
            ])
            ->first();

        if ($social_security) {
            $results['social_security'] = $social_security;
        } else {
            $results['social_security'] = null;
        }

        return $results;
    }

    public function store(CollaboratorSocialSecurityCreateRequest $request)
    {
        // Las validaciones se realizan en CollaboratorSocialSecurityCreateRequest

        try {
            $company_id = Auth::user()->company_id;
            $collaborator_id = $request->collaborator_id;

            // 1. Define la ruta base de Cloudinary para no repetirla
            $folderPath = 'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/' . $collaborator_id . '/social_securities';

            // 2. Inicializa el array $data con TODOS los campos no-archivo
            $data = [
                'collaborator_id' => $collaborator_id,
                'eps_id'          => $request->eps_id,
                'afp_pension_id'  => $request->afp_pension_id,
                'afp_saving_id'   => $request->afp_saving_id,
                'ccf_id'          => $request->ccf_id,
                'arl_id'          => $request->arl_id,
                'observations'    => $request->observations
            ];

            // 3. Procesa 'eps_file' si existe
            if ($request->hasFile('eps_file')) {
                $file = $request->file('eps_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                $data['eps_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['eps_certificate_url'] = $cloudinary_object->getSecurePath();
            }

            // 4. Procesa 'afp_pension_file' si existe
            if ($request->hasFile('afp_pension_file')) {
                $file = $request->file('afp_pension_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                // Asumo estos nombres de columna, ajústalos si es necesario
                $data['afp_pension_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['afp_pension_certificate_url'] = $cloudinary_object->getSecurePath();
            }

            // 5. Procesa 'afp_saving_file' si existe
            if ($request->hasFile('afp_saving_file')) {
                $file = $request->file('afp_saving_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                // Asumo estos nombres de columna, ajústalos si es necesario
                $data['afp_saving_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['afp_saving_certificate_url'] = $cloudinary_object->getSecurePath();
            }

            // 6. Crea el registro con todos los datos recopilados
            $socialSecurity = CollaboratorSocialSecurity::create($data);

            return response()->json([
                'message' => 'Información de seguridad social ingresada exitosamente!',
                'social_security_data' => $socialSecurity // Es mejor devolver el modelo creado
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CollaboratorSocialSecurityEditRequest $request, $social_security_id)
    {
        // Las validaciones se realizan en CollaboratorSocialSecurityEditRequest

        try {
            $company_id = Auth::user()->company_id;

            // Usar findOrFail es más limpio: si no lo encuentra, falla con un 404
            $social_security = CollaboratorSocialSecurity::findOrFail($social_security_id);

            // 1. Define la ruta base de Cloudinary
            // Usa el ID del colaborador guardado, por si acaso no viene en el request
            $folderPath = 'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/' . $social_security->collaborator_id . '/social_securities';

            // 2. Inicializa $data con los campos de texto
            $data = [
                'collaborator_id' => $request->collaborator_id,
                'eps_id'          => $request->eps_id,
                'afp_pension_id'  => $request->afp_pension_id,
                'afp_saving_id'   => $request->afp_saving_id,
                'ccf_id'          => $request->ccf_id,
                'arl_id'          => $request->arl_id,
                'observations'    => $request->observations
            ];

            // 3. Procesa 'eps_file' si se envió uno nuevo
            if ($request->hasFile('eps_file')) {
                // Borra el archivo anterior si existe
                if ($social_security->eps_certificate_public_id) {
                    Cloudinary::destroy($social_security->eps_certificate_public_id);
                }
                // Sube el nuevo
                $file = $request->file('eps_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                $data['eps_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['eps_certificate_url'] = $cloudinary_object->getSecurePath();
            }

            // 4. Procesa 'afp_pension_file' si se envió uno nuevo
            if ($request->hasFile('afp_pension_file')) {
                // Borra el archivo anterior si existe
                if ($social_security->afp_pension_public_id) {
                    Cloudinary::destroy($social_security->afp_pension_public_id);
                }
                // Sube el nuevo
                $file = $request->file('afp_pension_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                $data['afp_pension_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['afp_pension_certificate_url'] = $cloudinary_object->getSecurePath();
            }

            // 5. Procesa 'afp_saving_file' si se envió uno nuevo
            if ($request->hasFile('afp_saving_file')) {
                // Borra el archivo anterior si existe
                if ($social_security->afp_saving_public_id) {
                    Cloudinary::destroy($social_security->afp_saving_public_id);
                }
                // Sube el nuevo
                $file = $request->file('afp_saving_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                $data['afp_saving_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['afp_saving_certificate_url'] = $cloudinary_object->getSecurePath();
            }

            // 6. Actualiza el registro en la BD
            $social_security->update($data);

            return response()->json([
                'message' => 'Información de seguridad social actualizada exitosamente!',
                // Devuelve el modelo actualizado
                'social_security_data' => $social_security->fresh(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500); // Devuelve un código 500 en caso de error
        }
    }

    public function downloadEpsCertificate($social_security_id) {
        try {
            $social_security = CollaboratorSocialSecurity::where('id', $social_security_id)->first();
            $certificate_download_url = $social_security->eps_certificate_url;

            return response()->json([
                'certificate_download_url' => $certificate_download_url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function downloadAfpPensionCertificate($social_security_id) {
        try {
            $social_security = CollaboratorSocialSecurity::where('id', $social_security_id)->first();
            $certificate_download_url = $social_security->afp_pension_certificate_url;

            return response()->json([
                'certificate_download_url' => $certificate_download_url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function downloadAfpSavingCertificate($social_security_id) {
        try {
            $social_security = CollaboratorSocialSecurity::where('id', $social_security_id)->first();
            $certificate_download_url = $social_security->afp_saving_certificate_url;

            return response()->json([
                'certificate_download_url' => $certificate_download_url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($social_security_id)
    {
        // abort_if(Gate::denies('collaborator_destroy'), 403);

        try {
            // 1. Encuentra el registro o falla
            $social_security = CollaboratorSocialSecurity::findOrFail($social_security_id);

            // 2. Destruye todos los archivos asociados en Cloudinary
            if ($social_security->eps_certificate_public_id) {
                Cloudinary::destroy($social_security->eps_certificate_public_id);
            }
            if ($social_security->afp_pension_certificate_public_id) {
                Cloudinary::destroy($social_security->afp_pension_certificate_public_id);
            }
            if ($social_security->afp_saving_certificate_public_id) {
                Cloudinary::destroy($social_security->afp_saving_certificate_public_id);
            }

            // 3. Borra el registro de la base de datos
            $social_security->delete();

            return response()->json([
                'message' => 'Información de seguridad social eliminada exitosamente!',
                'social_security' => $social_security
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
