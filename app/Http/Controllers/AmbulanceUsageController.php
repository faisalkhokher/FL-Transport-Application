<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\AmbulanceUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AmbulanceUsagesExport;
use Illuminate\Support\Facades\Session;

class AmbulanceUsageController extends Controller
{
    public function index()
    {
        $page  = 'ambulance_usages';
        return view('admin.ambulance-usage.ambulance' , compact('page'));
    }

    public function AdminStoreAmbulanceUsage(Request $request)
    {
        $Village = $request['village_id'];
        $Ambulance = $request['ambulance_id'];
        $Date = $request['date'];
        $PatientName = $request['name'];
        $Age = $request['age_of_patient'];
        $Gender = $request['gender'];
        $HealthyFacility = $request['health_facility'];
        $Timeofdeparture = $request['time_of_departure'];
        $Typeofcase = $request['type_of_case'];
        $Deceased = "No";
        if (isset($request['deceased'])) {
          $Deceased = $request['deceased'];
        }
        DB::beginTransaction();
        $affected = AmbulanceUsage::create([
            'date' => $Date,
            'name' => $PatientName,
            'age_of_patient' => $Age,
            'gender' => $Gender,
            'village_id' => $Village,
            'health_facility' => $HealthyFacility,
            'time_of_departure' => $Timeofdeparture,
            'type_of_case' => $Typeofcase,
            'ambulance_id' => $Ambulance,
            'deceased' => $Deceased,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($affected) {
            DB::commit();
            return response()->json("Success", 200);
        }
        else {
            DB::rollback();
            return response()->json("Error", 400);
        }
    }

    public function LoadAmbulanceUsages(Request $request)
    {
        $Role = Session::get('user_role');
        $limit = $request->post('length');
        $start = $request->post('start');
        $searchTerm = $request->post('search')['value'];

        $columnIndex = $request->post('order')[0]['column']; // Column index
        $columnName = $request->post('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->post('order')[0]['dir']; // asc or desc

        $fetch_data = null;
        $recordsTotal = null;
        $recordsFiltered = null;

        if ($searchTerm == '') {
            $fetch_data = DB::table('ambulance_usages')
                ->where('ambulance_usages.deleted_at', '=', null)
                ->join('villages' , 'villages.id' , '=' , 'ambulance_usages.village_id')
                ->join('ambulances' , 'ambulances.id' , '=' , 'ambulance_usages.ambulance_id')
                ->select('ambulance_usages.*' , 'villages.name As village_name' ,'ambulances.name As ambulances_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('ambulance_usages')
                ->where('ambulance_usages.deleted_at', '=', null)
                ->join('villages' , 'villages.id' , '=' , 'ambulance_usages.village_id')
                ->join('ambulances' , 'ambulances.id' , '=' , 'ambulance_usages.ambulance_id')
                ->select('ambulance_usages.*' , 'villages.name As village_name' ,'ambulances.name As ambulances_name')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('ambulance_usages')
            ->join('villages' , 'villages.id' , '=' , 'ambulance_usages.village_id')
            ->join('ambulances' , 'ambulances.id' , '=' , 'ambulance_usages.ambulance_id')
                ->where('ambulance_usages.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('ambulance_usages.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('ambulance_usages.*' , 'villages.name As village_name' ,'ambulances.name As ambulances_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('ambulance_usages')
            ->join('villages' , 'villages.id' , '=' , 'ambulance_usages.village_id')
            ->join('ambulances' , 'ambulances.id' , '=' , 'ambulance_usages.ambulance_id')
                ->where('ambulance_usages.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('ambulance_usages.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('ambulance_usages.*' , 'villages.name As village_name' ,'ambulances.name As ambulances_name')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['date'] = $item->date;
          $sub_array['patient_name'] = '<span>' . wordwrap($item->name, 10, "<br>") . '</span>';
          $sub_array['age_of_patient'] = '<span>' . wordwrap($item->age_of_patient, 10, "<br>") . '</span>';
          $sub_array['gender'] = $item->gender;
          $sub_array['village'] = '<span>' . wordwrap($item->village_name, 10, "<br>") . '</span>';
          $sub_array['health_facility'] = '<span>' . wordwrap($item->health_facility, 10, "<br>") . '</span>';
          $sub_array['time_of_departure'] = Carbon::parse($item->time_of_departure)->format('g:i A');
          $sub_array['type_of_case'] = '<span>' . wordwrap($item->type_of_case, 10, "<br>") . '</span>';
          $sub_array['deceased'] = '<span>' . wordwrap($item->deceased, 10, "<br>") . '</span>';
          $sub_array['ambulance'] = '<span>' . wordwrap($item->ambulances_name, 10, "<br>") . '</span>';
          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->date . '_' . $item->name . '_' . $item->age_of_patient . '_' . $item->gender . '_' . $item->village_id .'_' . $item->health_facility .'_' . $item->time_of_departure. '_' . $item->type_of_case. '_' . $item->deceased. '_' . $item->ambulance_id. '" onclick="editAmbulanceUsage(this.id);"><i class="fas fa-edit"></i></button><button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteAmbulanceUsage(this.id);"><i class="fas fa-trash"></i></button>';
        }
        else
        {
            $sub_array['action'] = '';
        }

          $SrNo++;
          $data[] = $sub_array;
        }

        $json_data = array(
          "draw" => intval($request->post('draw')),
          "recordsTotal" => $recordsTotal,
          "recordsFiltered" => $recordsFiltered,
          "data" => $data
      );

        echo json_encode($json_data);
    }


   public function Delete(Request $request)
   {
      $deleteAmbulanceUsageId = $request->deleteAmbulanceUsageId;
      $affected = null;
      DB::beginTransaction();
      $affected = DB::table('ambulance_usages')
          ->where('id', $deleteAmbulanceUsageId)
          ->update([
              'updated_at' => Carbon::now(),
              'deleted_at' => Carbon::now()
          ]);
      if ($affected) {
        DB::commit();
        echo "Success";
      }
      else {
        DB::rollback();
        echo "Error";
      }
   }

   public function UpdateAmbulanceUsage(Request $request)
   {
       $page = "ambulance_usages";
       $ambulance_id = $request['id'];
       $Village = $request['village_id'];
       $Ambulance = $request['ambulance_id'];
       $Date = $request['date'];
       $PatientName = $request['name'];
       $Age = $request['age_of_patient'];
       $Gender = $request['gender'];
       $HealthyFacility = $request['health_facility'];
       $Timeofdeparture = $request['time_of_departure'];
       $Typeofcase = $request['type_of_case'];
       $Deceased = "No";
       if (isset($request['deceased'])) {
         $Deceased = $request['deceased'];
       }

       DB::beginTransaction();
       $affected = DB::table('ambulance_usages')
        ->where('id', $ambulance_id)
        ->update([
          'date' => $Date,
          'name' => $PatientName,
          'age_of_patient' => $Age,
          'gender' => $Gender,
          'village_id' => $Village,
          'health_facility' => $HealthyFacility,
          'time_of_departure' => $Timeofdeparture,
          'type_of_case' => $Typeofcase,
          'ambulance_id' => $Ambulance,
          'deceased' => $Deceased,
          'updated_at' => Carbon::now(),
       ]);

       DB::commit();
       return response()->json("Success", 200);
   }

   public function export()
   {
       return Excel::download(new AmbulanceUsagesExport, 'ambulancesusages.xlsx');
   }
}
