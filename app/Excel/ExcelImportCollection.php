<?php

namespace App\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImportCollection implements ToCollection
{
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
