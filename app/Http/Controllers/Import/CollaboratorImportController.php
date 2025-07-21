<?php

namespace App\Http\Controllers\Import;

use App\Exports\CollaboratorErrorsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\CollaboratorsImport;
use App\Mail\CollaboratorUploadErrorsMail;
use App\Mail\CollaboratorUploadSuccessMail;
use App\Models\City;
use App\Models\CivilStatusType;
use App\Models\Collaborator;
use App\Models\CollaboratorImport;
use App\Models\DocumentType;
use App\Models\HousingTenure;
use App\Models\Province;
use App\Models\RhType;
use App\Models\SexType;
use App\Models\SocialStratum;
use Dom\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CollaboratorImportController extends Controller
{
    public $company_id;
    public $errors;
    protected $hash;

    public function __construct()
    {
        $this->company_id = '';
        $this->errors = [];
        $this->hash = '';
    }

    public function import(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $this->company_id = $request->input('company_id');
        $this->hash = Hash::make(Auth::user()->id);

        // Cargamos el archivo en la tabla temporal tmp_collaborator_imports
        Excel::import(new CollaboratorsImport($this->company_id, $this->hash), $request->file('file'));

        // Validaciones
        $this->validations();

        // Generamos el archivo de errores
        $this->generateErrorFile();

        // Procesamos los datos
        $executionTime = $this->saveCollaborators();

        //limpiamos tablas temporales
        CollaboratorImport::where('hash', $this->hash)->delete();

        return response()->json([
            'message' => 'Colaboradores importados correctamente.'
        ]);
    }

    protected function validations()
    {
        // Validación de tipo de documento nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Tipo de documento nulo'
                ELSE CONCAT(errors, ' | ', 'Tipo de documento nulo')
            END
        WHERE hash = ? AND (`document_type` IS NULL OR `document_type` = '')", [$this->hash]);

        // Validación de tipo de documento no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Tipo de documento no válido'
                ELSE CONCAT(errors, ' | ', 'Tipo de documento no válido')
            END
        WHERE hash = ? AND `document_type` NOT IN (SELECT type FROM document_types)", [$this->hash]);

        // Validación de número de documento nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Número de documento nulo'
                ELSE CONCAT(errors, ' | ', 'Número de documento nulo')
            END
        WHERE hash = ? AND (`document_number` IS NULL OR `document_number` = '')", [$this->hash]);

        // Validación de número de documento no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Número de documento no válido'
                ELSE CONCAT(errors, ' | ', 'Número de documento no válido')
            END
        WHERE hash = ? AND `document_number` NOT REGEXP '^[0-9]+$'", [$this->hash]);

        // Validación de número de documento ya existe para la empresa
        DB::update("UPDATE tmp_collaborator_imports AS t1
            JOIN (
                SELECT t2.document_number, t2.hash
                FROM tmp_collaborator_imports t2
                WHERE t2.company_id = ?
                GROUP BY t2.document_number, t2.hash
                HAVING COUNT(*) > 1
            ) AS dup ON dup.document_number = t1.document_number AND dup.hash = t1.hash
            SET t1.errors = CASE
                WHEN t1.errors IS NULL OR t1.errors = ''
                    THEN 'Número de documento ya existe para la empresa'
                ELSE CONCAT(t1.errors, ' | ', 'Número de documento ya existe para la empresa')
            END
            WHERE t1.hash = ?
        ", [$this->company_id, $this->hash]);

        // Validación de número de documento duplicado
        DB::update("UPDATE tmp_collaborator_imports AS t1
            JOIN (
                SELECT t2.document_number, t2.hash
                FROM tmp_collaborator_imports t2
                GROUP BY t2.document_number, t2.hash
                HAVING COUNT(*) > 1
            ) AS dup ON dup.document_number = t1.document_number AND dup.hash = t1.hash
            SET t1.errors = CASE
                WHEN t1.errors IS NULL OR t1.errors = ''
                    THEN 'Número de documento duplicado'
                ELSE CONCAT(t1.errors, ' | ', 'Número de documento duplicado')
            END
            WHERE t1.hash = ?
        ", [$this->hash]);

        // Validación de fecha de expedición nula
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Fecha de expedición nula'
                ELSE CONCAT(errors, ' | ', 'Fecha de expedición nula')
            END
        WHERE hash = ? AND (`expedition_date` IS NULL OR `expedition_date` = '')", [$this->hash]);

        // Validación de fecha de expedición no válida
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Fecha de expedición no válida'
                ELSE CONCAT(errors, ' | ', 'Fecha de expedición no válida')
            END
            WHERE hash = ?
            AND expedition_date IS NOT NULL
            AND is_valid_date(expedition_date) = 0
        ", [$this->hash]);

        // Validación de departamento de expedición nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Departamento de expedición nulo'
                ELSE CONCAT(errors, ' | ', 'Departamento de expedición nulo')
            END
        WHERE hash = ? AND (`document_province` IS NULL OR `document_province` = '')", [$this->hash]);

        // Validación de departamento de expedición no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Departamento de expedición no válido'
                ELSE CONCAT(errors, ' | ', 'Departamento de expedición no válido')
            END
        WHERE hash = ? AND `document_province` NOT IN (SELECT name FROM provinces)", [$this->hash]);

        // Validación de municipio de expedición nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de expedición nulo'
                ELSE CONCAT(errors, ' | ', 'Municipio de expedición nulo')
            END
        WHERE hash = ? AND (`document_city` IS NULL OR `document_city` = '')", [$this->hash]);

        // Validación de municipio de expedición no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de expedición no válido'
                ELSE CONCAT(errors, ' | ', 'Municipio de expedición no válido')
            END
        WHERE hash = ? AND `document_city` NOT IN (SELECT name FROM cities)", [$this->hash]);

        // Validación de municipio de expedición no coincide con el departamento
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de expedición no coincide con el departamento'
                ELSE CONCAT(errors, ' | ', 'Municipio de expedición no coincide con el departamento')
            END
        WHERE hash = ?
        AND (`document_province` IS NOT NULL AND `document_city` IS NOT NULL)
        AND EXISTS (
            SELECT 1
            FROM provinces p
            JOIN cities c ON c.province_id = p.id
            WHERE p.name = tmp_collaborator_imports.document_province
            AND c.name = tmp_collaborator_imports.document_city
        ) = 0", [$this->hash]);

        // Validación de nombre nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Nombre nulo'
                ELSE CONCAT(errors, ' | ', 'Nombre nulo')
            END
        WHERE hash = ? AND (`name` IS NULL OR `name` = '')", [$this->hash]);

        // Validación de primer apellido nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Primer apellido nulo'
                ELSE CONCAT(errors, ' | ', 'Primer apellido nulo')
            END
        WHERE hash = ? AND (`first_surname` IS NULL OR `first_surname` = '')", [$this->hash]);

        // Validación de segundo apellido nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Segundo apellido nulo'
                ELSE CONCAT(errors, ' | ', 'Segundo apellido nulo')
            END
        WHERE hash = ? AND (`second_surname` IS NULL OR `second_surname` = '')", [$this->hash]);

        // Validación de estado civil nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Estado civil nulo'
                ELSE CONCAT(errors, ' | ', 'Estado civil nulo')
            END
        WHERE hash = ? AND (`civil_status_type` IS NULL OR `civil_status_type` = '')", [$this->hash]);

        // Validación de estado civil no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Estado civil no válido'
                ELSE CONCAT(errors, ' | ', 'Estado civil no válido')
            END
        WHERE hash = ? AND `civil_status_type` NOT IN (SELECT type FROM civil_status_types)", [$this->hash]);

        // Validación de sexo nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Sexo nulo'
                ELSE CONCAT(errors, ' | ', 'Sexo nulo')
            END
        WHERE hash = ? AND (`sex_type` IS NULL OR `sex_type` = '')", [$this->hash]);

        // Validación de sexo no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Sexo no válido'
                ELSE CONCAT(errors, ' | ', 'Sexo no válido')
            END
        WHERE hash = ? AND `sex_type` NOT IN (SELECT name FROM sex_types)", [$this->hash]);

        // Validación de tipo de RH nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Tipo de RH nulo'
                ELSE CONCAT(errors, ' | ', 'Tipo de RH nulo')
            END
        WHERE hash = ? AND (`rh_type` IS NULL OR `rh_type` = '')", [$this->hash]);

        // Validación de tipo de RH no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Tipo de RH no válido'
                ELSE CONCAT(errors, ' | ', 'Tipo de RH no válido')
            END
        WHERE hash = ? AND `rh_type` NOT IN (SELECT name FROM rh_types)", [$this->hash]);

        // Validación de fecha de nacimiento nula
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Fecha de nacimiento nula'
                ELSE CONCAT(errors, ' | ', 'Fecha de nacimiento nula')
            END
        WHERE hash = ? AND (`birth_date` IS NULL OR `birth_date` = '')", [$this->hash]);

        // Validación de fecha de nacimiento no válida
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Fecha de nacimiento no válida'
                ELSE CONCAT(errors, ' | ', 'Fecha de nacimiento no válida')
            END
            WHERE hash = ?
            AND birth_date IS NOT NULL
            AND is_valid_date(birth_date) = 0
        ", [$this->hash]);

        // Validación de departamento de nacimiento nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Departamento de nacimiento nulo'
                ELSE CONCAT(errors, ' | ', 'Departamento de nacimiento nulo')
            END
        WHERE hash = ? AND (`birth_province` IS NULL OR `birth_province` = '')", [$this->hash]);

        // Validación de departamento de nacimiento no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Departamento de nacimiento no válido'
                ELSE CONCAT(errors, ' | ', 'Departamento de nacimiento no válido')
            END
        WHERE hash = ? AND `birth_province` NOT IN (SELECT name FROM provinces)", [$this->hash]);

        // Validación de municipio de nacimiento nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de nacimiento nulo'
                ELSE CONCAT(errors, ' | ', 'Municipio de nacimiento nulo')
            END
        WHERE hash = ? AND (`birth_city` IS NULL OR `birth_city` = '')", [$this->hash]);

        // Validación de municipio de nacimiento no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de nacimiento no válido'
                ELSE CONCAT(errors, ' | ', 'Municipio de nacimiento no válido')
            END
        WHERE hash = ? AND `birth_city` NOT IN (SELECT name FROM cities)", [$this->hash]);

        // Validación de municipio de nacimiento no coincide con el departamento
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de nacimiento no coincide con el departamento'
                ELSE CONCAT(errors, ' | ', 'Municipio de nacimiento no coincide con el departamento')
            END
        WHERE hash = ?
        AND (`birth_province` IS NOT NULL AND `birth_city` IS NOT NULL)
        AND EXISTS (
            SELECT 1
            FROM provinces p
            JOIN cities c ON c.province_id = p.id
            WHERE p.name = tmp_collaborator_imports.birth_province
            AND c.name = tmp_collaborator_imports.birth_city
        ) = 0", [$this->hash]);

        // Validación de departamento de residencia nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Departamento de residencia nulo'
                ELSE CONCAT(errors, ' | ', 'Departamento de residencia nulo')
            END
        WHERE hash = ? AND (`residence_province` IS NULL OR `residence_province` = '')", [$this->hash]);

        // Validación de departamento de residencia no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Departamento de residencia no válido'
                ELSE CONCAT(errors, ' | ', 'Departamento de residencia no válido')
            END
        WHERE hash = ? AND `residence_province` NOT IN (SELECT name FROM provinces)", [$this->hash]);

        // Validación de municipio de residencia nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de residencia nulo'
                ELSE CONCAT(errors, ' | ', 'Municipio de residencia nulo')
            END
        WHERE hash = ? AND (`residence_city` IS NULL OR `residence_city` = '')", [$this->hash]);

        // Validación de municipio de residencia no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de residencia no válido'
                ELSE CONCAT(errors, ' | ', 'Municipio de residencia no válido')
            END
        WHERE hash = ? AND `residence_city` NOT IN (SELECT name FROM cities)", [$this->hash]);

        // Validación de municipio de residencia no coincide con el departamento
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Municipio de residencia no coincide con el departamento'
                ELSE CONCAT(errors, ' | ', 'Municipio de residencia no coincide con el departamento')
            END
        WHERE hash = ?
        AND (`residence_province` IS NOT NULL AND `residence_city` IS NOT NULL)
        AND EXISTS (
            SELECT 1
            FROM provinces p
            JOIN cities c ON c.province_id = p.id
            WHERE p.name = tmp_collaborator_imports.residence_province
            AND c.name = tmp_collaborator_imports.residence_city
        ) = 0", [$this->hash]);

        // Validación de dirección nula
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Dirección nula'
                ELSE CONCAT(errors, ' | ', 'Dirección nula')
            END
        WHERE hash = ? AND (`address` IS NULL OR `address` = '')", [$this->hash]);

        // Validación de tenencia de vivienda nula
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Tenencia de vivienda nula'
                ELSE CONCAT(errors, ' | ', 'Tenencia de vivienda nula')
            END
        WHERE hash = ? AND (`housing_tenure` IS NULL OR `housing_tenure` = '')", [$this->hash]);

        // Validación de tenencia de vivienda no válida
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Tenencia de vivienda no válida'
                ELSE CONCAT(errors, ' | ', 'Tenencia de vivienda no válida')
            END
        WHERE hash = ? AND `housing_tenure` NOT IN (SELECT type FROM housing_tenures)", [$this->hash]);

        // Validación de estrato social nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Estrato social nulo'
                ELSE CONCAT(errors, ' | ', 'Estrato social nulo')
            END
        WHERE hash = ? AND (`stratum_type` IS NULL OR `stratum_type` = '')", [$this->hash]);

        // Validación de estrato social no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Estrato social no válido'
                ELSE CONCAT(errors, ' | ', 'Estrato social no válido')
            END
        WHERE hash = ? AND `stratum_type` NOT IN (SELECT name FROM social_strata)", [$this->hash]);

        // Validación de teléfono nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Teléfono nulo'
                ELSE CONCAT(errors, ' | ', 'Teléfono nulo')
            END
        WHERE hash = ? AND (`phone` IS NULL OR `phone` = '')", [$this->hash]);

        // Validación de teléfono no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Teléfono no válido'
                ELSE CONCAT(errors, ' | ', 'Teléfono no válido')
            END
        WHERE hash = ?
            AND phone IS NOT NULL
            AND phone NOT REGEXP '^[0-9]{7}$'", [$this->hash]);

        // Validación de celular nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Celular nulo'
                ELSE CONCAT(errors, ' | ', 'Celular nulo')
            END
        WHERE hash = ? AND (`cellphone` IS NULL OR `cellphone` = '')", [$this->hash]);

        // Validación de celular no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Celular no válido'
                ELSE CONCAT(errors, ' | ', 'Celular no válido')
            END
        WHERE hash = ?
            AND cellphone IS NOT NULL
            AND cellphone NOT REGEXP '^[0-9]{10}$'", [$this->hash]);

        // Validación de email nulo
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Email nulo'
                ELSE CONCAT(errors, ' | ', 'Email nulo')
            END
        WHERE hash = ? AND (`email` IS NULL OR `email` = '')", [$this->hash]);

        // Validación de email no válido
        DB::update("UPDATE tmp_collaborator_imports
            SET errors = CASE
                WHEN errors IS NULL OR errors = ''
                    THEN 'Email no válido'
                ELSE CONCAT(errors, ' | ', 'Email no válido')
            END
        WHERE hash = ? AND `email` IS NOT NULL
            AND email NOT REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$'", [$this->hash]);

        // INSERTAR OTRAS VALIDACIONES AQUÍ
    }

    protected function generateErrorFile()
    {
        $errors = CollaboratorImport::where('hash', $this->hash)
            ->whereNotNull('errors')
            ->get()
            ->makeHidden(['id', 'company_id', 'hash']);

        if ($errors->isNotEmpty()) {
            // Ruta donde guardar el archivo
            $filename = 'upload-collaborators-errors-' . now()->format('Ymd_His') . '.xlsx';
            $path = storage_path('app/public/upload-collaborators/errors/' . $filename);

            // Asegúrate de que el directorio exista
            if (!File::isDirectory(dirname($path))) {
                File::makeDirectory(dirname($path), 0777, true, true);
            }

            Excel::store(new CollaboratorErrorsExport($errors), 'public/upload-collaborators/errors/' . $filename);

            Mail::to([Auth::user()->email])
                ->send(new CollaboratorUploadErrorsMail($filename));

            $this->deleteFile($path);
        } else {
            Mail::to([Auth::user()->email])
                ->send(new CollaboratorUploadSuccessMail());
        }
    }

    protected function deleteFile($path)
    {
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function saveCollaborators()
    {
        // Registrar tiempo de inicio
        $startTime = microtime(true);

        $validRows = CollaboratorImport::where('hash', $this->hash)->whereNull('errors')->get();

        DB::beginTransaction();

        try {
            foreach ($validRows as $row) {
                Collaborator::create([
                    'company_id'             => $row->company_id,
                    'document_type_id'       => DocumentType::where('type', $row->document_type)->first()->id ?? null,
                    'document_number'        => $row->document_number,
                    'expedition_date'        => $row->expedition_date,
                    'document_province_id'   => Province::where('name', $row->document_province)->first()->id ?? null,
                    'document_city_id'       => City::where('name', $row->document_city)->first()->id ?? null,
                    'name'                   => $row->name,
                    'first_surname'          => $row->first_surname,
                    'second_surname'         => $row->second_surname,
                    'civil_status_type_id'   => CivilStatusType::where('type', $row->civil_status_type)->first()->id ?? null,
                    'sex_type_id'            => SexType::where('name', $row->sex_type)->first()->id ?? null,
                    'rh_type_id'             => RhType::where('name', $row->rh_type)->first()->id ?? null,
                    'birth_date'             => $row->birth_date,
                    'birth_province_id'      => Province::where('name', $row->birth_province)->first()->id ?? null,
                    'birth_city_id'          => City::where('name', $row->birth_city)->first()->id ?? null,
                    'residence_province_id'  => Province::where('name', $row->residence_province)->first()->id ?? null,
                    'residence_city_id'      => City::where('name', $row->residence_city)->first()->id ?? null,
                    'address'                => $row->address,
                    'housing_tenure_id'      => HousingTenure::where('type', $row->housing_tenure)->first()->id ?? null,
                    'stratum_type_id'        => SocialStratum::where('name', $row->stratum_type)->first()->id ?? null,
                    'phone'                  => $row->phone,
                    'cellphone'              => $row->cellphone,
                    'email'                  => $row->email,
                    'observations'           => $row->observations,
                ]);
            }

            DB::commit();

            // Calcular tiempo de ejecución al finalizar
            $executionTime = microtime(true) - $startTime;

            // return true;
            return $executionTime;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en saveCollaborators: " . $e->getMessage());
            return false;
        }
    }
}
