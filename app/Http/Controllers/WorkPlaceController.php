<?php

namespace App\Http\Controllers;

use Validator;
use App\Village;
use App\WorkPlace;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WorkPlaceController extends Controller
{
    public function ViewWorkplace(Request $request)
    {
        $page = "workplaces";
        $villages = Village::all();
        $villages = json_encode($villages);
        return view('admin.workplaces.workplaces' , compact('page', 'villages'));
    }

    public function AddWorkplace(Request $request)
    {
        $page = "workplaces";
        $villages = Village::all();
        return view('admin.workplaces.add-new' , compact('page','villages'));
    }

    public function StorWorkplace(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'work_places_id' => 'required',
        ]);

        $WorkPlace = new WorkPlace();
        $WorkPlace->name = $request->name;
        $WorkPlace->village_id = $request->village_id;
        $WorkPlace->save();
        return redirect()->route('admin.workplaces');
    }


    public function LoadWorkplaces(Request $request)
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
            $fetch_data = DB::table('work_places')
                ->where('work_places.deleted_at', '=', null)
                ->join('villages' , 'villages.id' , '=' , 'work_places.village_id')
                ->select('work_places.*' , 'villages.name As village_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('work_places')
                ->where('work_places.deleted_at', '=', null)
                ->select('work_places.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('work_places')
                ->where('work_places.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('work_places.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('work_places.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('work_places')
                ->where('work_places.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('work_places.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('work_places.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['name'] = $item->name;
          $sub_array['village_id'] = $item->village_name;
          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->name . '_' . $item->village_id . '" onclick="editWorkPlace(this.id);"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteWorkPlaces(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminDeleteWorkPlaces(Request $request)
    {
        $workplace_id = $request->id;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('work_places')
            ->where('id', $workplace_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.workplaces'))->with('message', 'WorkPlace has been deleted successfully');
        }
        else {
          DB::rollback();
          return redirect(route('admin.workplaces'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function AdminWorkPlaces(Request $request)
    {
        $page = "workplaces";
        $field_id = $request['id'];
        $new = WorkPlace::findOrFail($field_id);
        $new->name = $request->name;
        $new->village_id = $request->village_id;
        $new->save();
        return redirect(route('admin.workplaces'));
    }
}
