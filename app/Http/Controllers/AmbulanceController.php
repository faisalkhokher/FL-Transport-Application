<?php

namespace App\Http\Controllers;

use App\Ambulance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\AmbulancesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AmbulanceController extends Controller
{
   public function AdminStoreAmbulance(Request $request)
   {
      $input = $request->all();
      $data = Ambulance::create($input);
      return response()->json($data, 200);
   }

   public function LoadAmbulances(Request $request)
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
           $fetch_data = DB::table('ambulances')
               ->where('ambulances.deleted_at', '=', null)
               ->join('villages' , 'villages.id' , '=' , 'ambulances.village_id')
               ->join('sponsors' , 'sponsors.id' , '=' , 'ambulances.sponsor_id')
               ->join('work_places' , 'work_places.id' , '=' , 'ambulances.workplace_id')
               ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'ambulances.field_id')
               ->select('ambulances.*' , 'villages.name As village_name' ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name', 'work_places.name As workplaces_name')
               ->orderBy($columnName, $columnSortOrder)
               ->offset($start)
               ->limit($limit)
               ->get();
           $recordsTotal = sizeof($fetch_data);
           $recordsFiltered = DB::table('ambulances')
               ->where('ambulances.deleted_at', '=', null)
               ->select('ambulances.*')
               ->orderBy($columnName, $columnSortOrder)
               ->count();
       } else {
           $fetch_data = DB::table('ambulances')
               ->where('ambulances.deleted_at', '=', null)
               ->where(function ($query) use ($searchTerm) {
                   $query->orWhere('ambulances.name', 'LIKE', '%' . $searchTerm . '%');
               })
               ->select('ambulances.*')
               ->orderBy($columnName, $columnSortOrder)
               ->offset($start)
               ->limit($limit)
               ->get();
           $recordsTotal = sizeof($fetch_data);
           $recordsFiltered = DB::table('ambulances')
               ->where('ambulances.deleted_at', '=', null)
               ->where(function ($query) use ($searchTerm) {
                   $query->orWhere('ambulances.name', 'LIKE', '%' . $searchTerm . '%');
               })
               ->select('ambulances.*')
               ->orderBy($columnName, $columnSortOrder)
               ->count();
       }

       $data = array();
       $SrNo = $start + 1;

       foreach ($fetch_data as $row => $item) {
         $sub_array = array();
         $sub_array['id'] = $SrNo;
         $sub_array['name'] = '<span>' . wordwrap($item->name, 10, "<br>") . '</span>';
         $sub_array['village'] = '<span>' . wordwrap($item->village_name, 10, "<br>") . '</span>';
         $sub_array['latest_repair'] = $item->lastest_repair;
         $sub_array['next_repair'] = $item->next_repair;
         $sub_array['latitude'] = '<span>' . wordwrap($item->latitude, 12, "<br>") . '</span>';
         $sub_array['longitude'] = '<span>' . wordwrap($item->longitude, 12, "<br>") . '</span>';
         $sub_array['workplace'] = '<span>' . wordwrap($item->workplaces_name, 10, "<br>") . '</span>';
         $sub_array['sponsor'] = '<span>' . wordwrap($item->sponsor_name, 10, "<br>") . '</span>';
         $sub_array['field_officer'] = '<span>' . wordwrap($item->feild_name, 10, "<br>") . '</span>';
         if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->name . '_' . $item->latitude . '_' . $item->longitude . '_' . $item->village_id . '_' . $item->sponsor_id . '_' . $item->workplace_id . '_' . $item->field_id.  '_' . $item->lastest_repair .  '_' . $item->next_repair . '" onclick="editAmbulance(this.id);"><i class="fas fa-edit"></i></button><button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteAmbulance(this.id);"><i class="fas fa-trash"></i></button>';
         }
         else {
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
      $AmbulanceId = $request->AmbulanceId;
      $affected = null;
      DB::beginTransaction();
      $affected = DB::table('ambulances')
                  ->where('id', $AmbulanceId)
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

   public function AdminUpdateAmbulance(Request $request)
   {
       $page = "ambulances";
       $field_id = $request['id'];
       $input = $request->all();
       $new = Ambulance::findOrFail($field_id);
       $new->update($input);
       return response()->json('Success', 200);
   }

   public function export()
   {
       return Excel::download(new AmbulancesExport, 'ambulances.xlsx');
   }
}
