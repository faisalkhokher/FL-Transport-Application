<?php

namespace App\Http\Controllers;

use Validator;
use App\Fieldofficer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FieldOfficerController extends Controller
{

    public function ViewFieldOfficers(Request $request)
    {
        $page = "firldofficers";
        $fieldofficers = Fieldofficer::all();
        return view('admin.field-officers.fieldofficers' , compact('page','fieldofficers'));
    }

    public function AddFieldOfficers(Request $request)
    {
        $page = "firldofficers";
        return view('admin.field-officers.add-new' , compact('page'));
    }

    public function StoreFieldOfficers(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $fieldofficer = new Fieldofficer();
        $fieldofficer->name = $request->name;
        $fieldofficer->save();
        return redirect()->route('admin.field-officers');
    }

    public function LoadFieldOfficers(Request $request)
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
            $fetch_data = DB::table('fieldofficers')
                ->where('fieldofficers.deleted_at', '=', null)
                ->select('fieldofficers.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('fieldofficers')
                ->where('fieldofficers.deleted_at', '=', null)
                ->select('fieldofficers.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('fieldofficers')
                ->where('fieldofficers.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('fieldofficers.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('fieldofficers.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('fieldofficers')
                ->where('fieldofficers.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('fieldofficers.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('fieldofficers.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['name'] = $item->name;
          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->name . '" onclick="editFieldOfficer(this.id);"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteFieldOfficer(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminDeleteFieldOfficers(Request $request)
    {
        $fieldofficer_id = $request->id;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('fieldofficers')
            ->where('id', $fieldofficer_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.field-officers'))->with('message', 'Field Offcer has been deleted successfully');
        }
        else {
          DB::rollback();
          return redirect(route('admin.field-officers'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function AdminEditFieldOffficers(Request $request)
    {
        $page = "fieldofficers";
        $field_id = $request['id'];
        $field_details = DB::table('fieldofficers')
        ->where('fieldofficers.id', $field_id)
        ->select('fieldofficers.id AS fieldofficer')
        ->first();
        return view('admin.field-officers.edit', compact('page' , 'field_details'));
    }

    public function AdminUpdateFieldOffficers(Request $request)
    {
        $page = "fieldofficers";
        $field_id = $request['id'];
        $new = Fieldofficer::findOrFail($field_id);
        $new->name = $request->name;
        $new->save();
        return redirect(route('admin.field-officers'));
    }
}
