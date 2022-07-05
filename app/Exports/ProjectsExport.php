<?php

namespace App\Exports;

use App\Project;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection , WithHeadings
{
     public function headings(): array
    {
        return [
          'Title',
          'Start Time',
          'End Time',
          'Latitude',
          'Longitude',
          'Sponsor',
          'Field Officer',
          'Description',
        ];
    }
    public function collection()
    {
        $fetch_data = DB::table('projects')
        ->where('projects.deleted_at', '=', null)
        ->join('villages' , 'villages.id' , '=' , 'projects.village_id')
        ->join('sponsors' , 'sponsors.id' , '=' , 'projects.sponsor_id')
        ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'projects.field_id')
        ->select('projects.title','projects.start_time','projects.end_time' ,'projects.latitude' , 'projects.longitude'  ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name'
          ,'projects.description'
        )
        ->get();
        return $fetch_data;
    }
}
