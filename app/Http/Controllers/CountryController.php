<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class CountryController extends Controller
{
    public function ViewCountries(Request $request)
    {
        $page = "countries";
        return view('admin.countries.country' , compact('page'));
    }

    public function AddCountries(Request $request)
    {
        $page = "countries";
        return view('admin.countries.add-new' , compact('page'));
    }

    public function StoreCountries(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $countries = new Country();
        $countries->name = $request->name;
        $countries->country_code = $request->country_code;
        $countries->save();
        return redirect()->route('admin.countries');
    }

    public function LoadCountries(Request $request)
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
            $fetch_data = DB::table('countries')
                ->where('countries.deleted_at', '=', null)
                ->select('countries.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('countries')
                ->where('countries.deleted_at', '=', null)
                ->select('countries.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('countries')
                ->where('countries.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('countries.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('countries.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('countries')
                ->where('countries.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('countries.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('countries.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['name'] = $item->name;
          $sub_array['country_code'] = $item->country_code;

          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_'. $item->name .'_'. $item->country_code .'" onclick="editCountry(this.id);"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteCountry(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminDeleteCountryOfficers(Request $request)
    {
        $country_id = $request->id;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('countries')
            ->where('id', $country_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.countries'))->with('message', 'Country has been deleted successfully');
        }
        else {
          DB::rollback();
          return redirect(route('admin.countries'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function AdminUpdateCountries(Request $request)
    {
        $page = "countries";
        $id = $request['id'];
        $new = Country::findOrFail($id);
        $new->name = $request->name;
        $new->country_code = $request->country_code;
        $new->save();
        return redirect(route('admin.countries'));
    }
}
