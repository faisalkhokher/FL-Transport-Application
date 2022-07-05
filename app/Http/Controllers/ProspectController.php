<?php

namespace App\Http\Controllers;

use App\Prospect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\ProspectsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ProspectController extends Controller
{
    public function index()
    {
        $page  = 'prospect';
        return view('admin.prospects.prospect' , compact('page'));
    }

    public function AdminStoreprospects(Request $request)
    {
        $input = $request->all();
        $Prospect = Prospect::create($input);
        return $Prospect;
    }

    public function Loadprospects(Request $request)
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
            $fetch_data = DB::table('prospects')
                ->where('prospects.deleted_at', '=', null)
                ->join('sponsors' , 'sponsors.id' , '=' , 'prospects.sponsor_id')
                ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'prospects.field_id')
                ->select('prospects.*' ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('prospects')
                ->where('prospects.deleted_at', '=', null)
                ->select('prospects.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('prospects')
                ->where('prospects.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('prospects.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('prospects.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('prospects')
                ->where('prospects.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('prospects.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('prospects.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['Title'] = '<span>' . wordwrap($item->title, 10, "<br>") . '</span>';
          $sub_array['Description'] = '<span>' . wordwrap($item->description, 10, "<br>") . '</span>';
          $sub_array['Latitude'] = '<span>' . wordwrap($item->latitude, 10, "<br>") . '</span>';
          $sub_array['Longitude'] = '<span>' . wordwrap($item->longitude, 10, "<br>") . '</span>';
          $sub_array['Start date'] = $item->start_time;
          $sub_array['End date'] = $item->end_time;
          $sub_array['Sponsor'] = '<span>' . wordwrap($item->sponsor_name, 10, "<br>") . '</span>';
          $sub_array['Feildofficer'] = '<span>' . wordwrap($item->feild_name, 10, "<br>") . '</span>';

          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->title . '_' . $item->description . '_' . $item->latitude . '_' . $item->longitude .'_' . $item->start_time . '_' . $item->end_time . '_' . $item->sponsor_id . '_' . $item->field_id . '" onclick="editProspect(this.id);"><i class="fas fa-edit"></i></button><button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteprospect(this.id);"><i class="fas fa-trash"></i></button>';
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
        $ProspectsId = $request->ProspectsId;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('prospects')
            ->where('id', $ProspectsId)
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

   public function AdminUpdateProspect(Request $request)
   {
       $page = "prospects";
       $field_id = $request['id'];
       $input = $request->all();
       $new = Prospect::findOrFail($field_id);
       $new->update($input);
       return response()->json('Success', 200);
   }
   
   public function export()
   {
       return Excel::download(new ProspectsExport, 'ProspectsExport.xlsx');
   }
}
