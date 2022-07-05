<?php

namespace App\Http\Controllers;

use App\Sponsor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class SponsorController extends Controller
{
    public function ViewSponsors(Request $request)
    {
        $page = "sponsor";
        $sponsor = Sponsor::all();
        return view('admin.sponsor.sponsor' , compact('page','sponsor'));
    }

    public function AddSponsors(Request $request)
    {
        $page = "sponsor";
        return view('admin.sponsor.add-new' , compact('page'));
    }

    public function StoreSponsors(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $sponsor = new Sponsor();
        $sponsor->name = $request->name;
        $sponsor->save();
        return redirect()->route('admin.sponsors');
    }

    public function LoadSponsors(Request $request)
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
            $fetch_data = DB::table('sponsors')
                ->where('sponsors.deleted_at', '=', null)
                ->select('sponsors.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('sponsors')
                ->where('sponsors.deleted_at', '=', null)
                ->select('sponsors.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('sponsors')
                ->where('sponsors.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('sponsors.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('sponsors.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('sponsors')
                ->where('sponsors.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('sponsors.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('sponsors.*')
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
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->name . '" onclick="editSponser(this.id);"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteSponsorOfficer(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminDeleteSponsorOfficers(Request $request)
    {
        $affected = null;
        $sponser_id = $request->id;
        DB::beginTransaction();
        $affected = DB::table('sponsors')
            ->where('id', $sponser_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.sponsors'))->with('message', 'Sponsor has been deleted successfully');
        }
        else {
          DB::rollback();
          return redirect(route('admin.sponsors'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function AdminEditSponsors(Request $request)
    {
        $page = "sponsors";
        $sponsor_id = $request['id'];
        $sponsor = Fieldofficer::findOrFail($sponsor_id);
        return view('admin.sponsor.edit', compact('page' , 'sponsor','sponsor_id'));
    }

    public function AdminUpdateSponsors(Request $request)
    {
        $page = "sponsors";
        $id = $request['id'];
        $new = Sponsor::findOrFail($id);
        $new->name = $request->name;
        $new->save();
        return redirect(route('admin.sponsors'));
    }
}
