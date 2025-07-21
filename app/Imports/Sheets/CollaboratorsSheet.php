<?php

namespace App\Imports\Sheets;

use App\Models\CollaboratorImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CollaboratorsSheet implements ToCollection, WithHeadingRow
{
    protected $company_id;
    protected $hash;

    public function __construct($company_id, $hash)
    {
        $this->company_id = $company_id;
        $this->hash = $hash;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows->filter()->values() as $row) {
            CollaboratorImport::create([
                'company_id' => $this->company_id,
                'document_type' => $row->get("tipo_de_documento"),
                'document_number' => $row->get("numero_de_documento"),
                'expedition_date' => $row->get("fecha_de_expedicion"),
                'document_province' => $row->get("departamento_de_expedicion"),
                'document_city' => $row->get("municipio_de_expedicion"),
                'name' => $row->get("nombres"),
                'first_surname' => $row->get("primer_apellido"),
                'second_surname' => $row->get("segundo_apellido"),
                'civil_status_type' => $row->get("estado_civil"),
                'sex_type' => $row->get("sexo"),
                'rh_type' => $row->get("rh"),
                'birth_date' => $row->get("fecha_de_nacimiento"),
                'birth_province' => $row->get("departamento_de_nacimiento"),
                'birth_city' => $row->get("municipio_de_nacimiento"),
                'residence_province' => $row->get("departamento_de_residencia"),
                'residence_city' => $row->get("municipio_de_residencia"),
                'address' => $row->get("direccion"),
                'housing_tenure' => $row->get("tenencia_de_vivienda"),
                'stratum_type' => $row->get("estrato"),
                'phone' => $row->get("telefono"),
                'cellphone' => $row->get("celular"),
                'email' => $row->get("correo_electronico"),
                'observations' => $row->get("observaciones"),
                'hash' => $this->hash,
            ]);
        }
    }
}
