<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollaboratorErrorsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'TIPO DE DOCUMENTO',
            'NUMERO DE DOCUMENTO',
            'FECHA DE EXPEDICION',
            'DEPARTAMENTO DE EXPEDICION',
            'MUNICIPIO DE EXPEDICION',
            'NOMBRES',
            'PRIMER APELLIDO',
            'SEGUNDO APELLIDO',
            'ESTADO CIVIL',
            'SEXO',
            'RH',
            'FECHA DE NACIMIENTO',
            'DEPARTAMENTO DE NACIMIENTO',
            'MUNICIPIO DE NACIMIENTO',
            'DEPARTAMENTO DE RESIDENCIA',
            'MUNICIPIO DE RESIDENCIA',
            'DIRECCION',
            'TENENCIA DE VIVIENDA',
            'ESTRATO',
            'TELEFONO',
            'CELULAR',
            'CORREO ELECTRONICO',
            'OBSERVACIONES',
            'ERRORES',
        ];
    }
}

