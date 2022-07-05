<?php

namespace App\Exports;

use App\Wheelchair;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class WheelchairsExport implements FromCollection , WithHeadings
{
    public function headings(): array
    {
        return [
            'Name',
            'Latitude',
            'Longitude',
            'Latest Repair',
            'Next repair',
            'Sponsor',
            'Field Officer',
        ];
    }
    
    public function collection()
    {
        $fetch_data = DB::table('wheelchairs')
        ->where('wheelchairs.deleted_at', '=', null)
        ->join('sponsors' , 'sponsors.id' , '=' , 'wheelchairs.sponsor_id')
        ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'wheelchairs.field_id')
        ->select('wheelchairs.name' ,'wheelchairs.latitude','wheelchairs.longitude' ,'wheelchairs.latest_repair' ,'wheelchairs.next_repair' ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name',   )
        ->get();
        return $fetch_data;
    }
}
