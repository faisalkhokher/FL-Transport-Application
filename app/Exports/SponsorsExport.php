<?php

namespace App\Exports;

use App\Sponsor;
use Maatwebsite\Excel\Concerns\FromCollection;

class SponsorsExport implements FromCollection
{
    public function collection()
    {
        return Sponsor::all();
    }
}
