<?php

namespace App\Exports;

use App\Models\Penghuni;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenghuniExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Penghuni::all();
    }
}
