<?php

namespace App\Exports;

use App\Prospect;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProspectsExport implements FromCollection , WithHeadings
{
    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Start Time',
            'End Time',
            'Latitude',
            'Longitude',
            'Sponsor',
            'Field Officer',
         

        ];
    }
    public function collection()
    {
        $fetch_data = DB::table('prospects')
        ->where('prospects.deleted_at', '=', null)
        ->join('sponsors' , 'sponsors.id' , '=' , 'prospects.sponsor_id')
        ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'prospects.field_id')
        ->select('prospects.title' ,'prospects.description' ,  'prospects.start_time' , 'prospects.end_time' , 'prospects.latitude' , 'prospects.longitude' ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name',
         
        )
        ->get();

        return $fetch_data;
    }
}
