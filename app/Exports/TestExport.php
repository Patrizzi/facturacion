<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TestExport
{

    public function array()
    {
        return [
            ['Nombre', 'Correo'],
            ['Juan', 'juan@example.com'],
            ['Ana', 'ana@example.com'],
        ];
    }
}
