<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\Sheets\CollaboratorsSheet;

class CollaboratorsImport implements WithMultipleSheets
{
    protected $company_id;
    protected $hash;

    public function __construct($company_id, $hash)
    {
        $this->company_id = $company_id;
        $this->hash = $hash;
    }

    public function sheets(): array
    {
        return [
            // Nombre exacto de la hoja (case sensitive)
            'DATOS' => new CollaboratorsSheet($this->company_id, $this->hash),
        ];
    }
}
