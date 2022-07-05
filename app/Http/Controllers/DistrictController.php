<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use App\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use Carbon\Carbon;

class DistrictController extends Controller
{
    public function ViewDistrict(Request $request)
    {
        $page = "districts";
        $countries = Country::all();
        $countries = json_encode($countries);
        return view('admin.districts.districts' , compact('page','countries'));
    }

    public function AddDistrict(Request $request)
    {
        $page = "districts";
        $countries = Country::all();
        return view('admin.districts.add-new' , compact('page','countries'));
    }

    public function StorDistrict(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
        ]);

        $countries = new District();
        $countries->name = $request->name;
        $countries->country_id = $request->country_id;
        $countries->save();
        return redirect()->route('admin.districts');
    }


    public function LoadDistricts(Request $request)
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
            $fetch_data = DB::table('districts')
                ->where('districts.deleted_at', '=', null)
                ->join('countries' , 'countries.id' , '=' , 'districts.country_id')
                ->select('districts.*' , 'countries.name As country_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('districts')
                ->where('districts.deleted_at', '=', null)
                ->select('districts.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('districts')
                ->where('districts.deleted_at', '=', null)
                ->join('countries' , 'countries.id' , '=' , 'districts.country_id')
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('districts.name', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('countries.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('districts.*' , 'countries.name As country_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('districts')
                ->where('districts.deleted_at', '=', null)
                ->join('countries' , 'countries.id' , '=' , 'districts.country_id')
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('districts.name', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('countries.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('districts.*' , 'countries.name As country_name')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['name'] = $item->name;
          $sub_array['country_id'] = $item->country_name;
          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_'. $item->name .'_' . $item->country_id . '" onclick="editdistricts(this.id);"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteDistricts(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminDeleteDistricOfficers(Request $request)
    {
        $district_id = $request->id;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('districts')
            ->where('id', $district_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.districts'))->with('message', 'Districts has been deleted successfully');
        }
        else {
          DB::rollback();
          return redirect(route('admin.districts'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function AdminUpdateDistricts(Request $request)
    {
        $page = "districts";
        $field_id = $request['id'];
        $new = District::findOrFail($field_id);
        $new->name = $request->name;
        $new->country_id = $request->country_id;
        $new->save();
        return redirect(route('admin.districts'));
    }
}
