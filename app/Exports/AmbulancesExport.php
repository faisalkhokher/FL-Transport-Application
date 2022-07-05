<?php

namespace App\Exports;

use App\Ambulance;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AmbulancesExport implements FromCollection , WithHeadings
{
    public function headings(): array
    {
        return [
            'Name',
            'Village',
            'Latest Repair',
            'Next Repair',
            'Latitude',
            'Longitude',
            'Workplace',
            'Sponsor',
            'Field Officer',
        ];
    }

    public function collection()
    {
        $fetch_data =
        DB::table('ambulances')
        ->where('ambulances.deleted_at', '=', null)
        ->join('villages' , 'villages.id' , '=' , 'ambulances.village_id')
        ->join('sponsors' , 'sponsors.id' , '=' , 'ambulances.sponsor_id')
        ->join('work_places' , 'work_places.id' , '=' , 'ambulances.workplace_id')
        ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'ambulances.field_id')
        ->select('ambulances.name'  ,'villages.name As village_name','ambulances.lastest_repair','ambulances.next_repair',
         'ambulances.latitude', 'ambulances.longitude', 'work_places.name As workplaces_name','sponsors.name As sponsor_name'  , 'fieldofficers.name As feild_name'
        )
        ->get();
        return $fetch_data;
    }
}
