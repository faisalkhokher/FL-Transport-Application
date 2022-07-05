<?php

namespace App\Http\Controllers;

use Validator;
use App\Village;
use App\District;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VillageController extends Controller
{
    public function ViewVillage(Request $request)
    {
        $page = "villages";
        $districts = District::all();
        $districts = json_encode($districts);
        return view('admin.villages.villages' , compact('page', 'districts'));
    }

    public function AddVillage(Request $request)
    {
        $page = "villages";
        $districts = District::all();
        return view('admin.villages.add-new' , compact('page','districts'));
    }

    public function StoreVillage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'villages_id' => 'required',
        ]);

        $village = new Village();
        $village->name = $request->name;
        $village->district_id = $request->district_id;
        $village->save();
        return redirect()->route('admin.villages');
    }


    public function LoadVillages(Request $request)
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
            $fetch_data = DB::table('villages')
                ->where('villages.deleted_at', '=', null)
                ->join('districts' , 'districts.id' , '=' , 'villages.district_id')
                ->select('villages.*' , 'districts.name As district_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('villages')
                ->where('villages.deleted_at', '=', null)
                ->select('villages.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('villages')
                ->where('villages.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('villages.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('villages.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('villages')
                ->where('villages.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('villages.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('villages.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['name'] = $item->name;
          $sub_array['district_id'] = $item->district_name;
          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_'. $item->name .'_'. $item->district_id .'" onclick="editVillages(this.id);"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteVillages(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminDeleteVillages(Request $request)
    {
        $village_id = $request->id;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('villages')
            ->where('id', $village_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.villages'))->with('message', 'Village has been deleted successfully');
        }
        else {
          DB::rollback();
          return redirect(route('admin.villages'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function AdminUpdateVillage(Request $request)
    {
        $page = "villages";
        $field_id = $request['id'];
        $new = Village::findOrFail($field_id);
        $new->name = $request->name;
        $new->district_id = $request->district_id;
        $new->save();
        return redirect(route('admin.villages'));
    }
}
