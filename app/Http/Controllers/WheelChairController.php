<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Wheelchair;
use Illuminate\Http\Request;
use App\Exports\WheelchairsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class WheelChairController extends Controller
{
    public function index()
    {
        $page = 'wheelchair';
        return view('admin.wheeelchairs.wheeelchair' , compact('page'));
    }

    public function AdminStoreWheelchair(Request $request)
    {
        $input = $request->all();
        $Wheelchair = Wheelchair::create($input);
        return $Wheelchair;
    }

    public function LoadWheelchairs(Request $request)
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
            $fetch_data = DB::table('wheelchairs')
                ->where('wheelchairs.deleted_at', '=', null)
                ->join('sponsors' , 'sponsors.id' , '=' , 'wheelchairs.sponsor_id')
                ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'wheelchairs.field_id')
                ->select('wheelchairs.*'  ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('wheelchairs')
                ->where('wheelchairs.deleted_at', '=', null)
                ->select('wheelchairs.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('wheelchairs')
                ->where('wheelchairs.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('wheelchairs.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('wheelchairs.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('wheelchairs')
                ->where('wheelchairs.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('wheelchairs.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('wheelchairs.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['Name'] = '<span>' . wordwrap($item->name, 10, "<br>") . '</span>';
          $sub_array['Sponsor'] = '<span>' . wordwrap($item->sponsor_name, 10, "<br>") . '</span>';
          $sub_array['FieldOfficer'] = '<span>' . wordwrap($item->feild_name, 10, "<br>") . '</span>';
          $sub_array['Latitude'] = $item->latitude;
          $sub_array['Longitude'] = $item->longitude;
          $sub_array['Nextrepair'] = $item->next_repair;
          $sub_array['Latestrepair'] = $item->latest_repair;
          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->name . '_' . $item->sponsor_id . '_' . $item->field_id . '_' . $item->latitude . '_' . $item->longitude . '_' . $item->next_repair . '_' . $item->latest_repair . '" onclick="editWheelchair(this.id);"><i class="fas fa-edit"></i></button><button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteWheelchair(this.id);"><i class="fas fa-trash"></i></button>';
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
       $WheelchairId = $request->WheelchairId;
       $affected = null;
       DB::beginTransaction();
       $affected = DB::table('wheelchairs')
           ->where('id', $WheelchairId)
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

   public function AdminUpdateWheelchair(Request $request)
   {
       $page = "ambulances";
       $field_id = $request['id'];
       $input = $request->all();
       $new = Wheelchair::findOrFail($field_id);
       $new->update($input);
       return response()->json('Success', 200);
   }

   public function export()
   {
       return Excel::download(new WheelchairsExport, 'wheelchar.xlsx');
   }
}
