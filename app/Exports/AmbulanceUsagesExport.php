<?php

namespace App\Exports;

use App\AmbulanceUsage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AmbulanceUsagesExport implements FromCollection , WithHeadings
{
    public function headings(): array
    {
        return [
            'Date',
            'Patient name',
            'Age of patient',
            'Gender',
            'Village',
            'Health facility',
            'Time of departure',
            'Type of case',
            'Deceased',
            'Ambulance'
        ];
    }

    public function collection()
    {
       $fetch_data = DB::table('ambulance_usages')
      ->where('ambulance_usages.deleted_at', '=', null)
      ->join('villages' , 'villages.id' , '=' , 'ambulance_usages.village_id')
      ->join('ambulances' , 'ambulances.id' , '=' , 'ambulance_usages.ambulance_id')
      ->select('ambulance_usages.date','ambulance_usages.name' , 'ambulance_usages.age_of_patient','ambulance_usages.gender' , 'villages.name As village_name','ambulance_usages.health_facility' ,'ambulance_usages.time_of_departure','ambulance_usages.type_of_case','ambulance_usages.deceased','ambulances.name As ambulances_name')
      ->get();
      return $fetch_data;
    }
}
