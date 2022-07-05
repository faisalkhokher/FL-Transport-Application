<?php

namespace App\Http\Controllers;

use App\Project;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Exports\ProjectsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    public function index()
    {
        $page  = 'projects';
        return view('admin.projects.project' , compact('page'));
    }

    public function AdminStoreProjects(Request $request)
    {
        $input = $request->all();
        $project = Project::create($input);
        return $project;
    }

    public function LoadProjects(Request $request)
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
            $fetch_data = DB::table('projects')
                ->where('projects.deleted_at', '=', null)
                ->join('villages' , 'villages.id' , '=' , 'projects.village_id')
                ->join('sponsors' , 'sponsors.id' , '=' , 'projects.sponsor_id')
                ->join('fieldofficers' , 'fieldofficers.id' , '=' , 'projects.field_id')
                ->select('projects.*' , 'villages.name As village_name' ,'sponsors.name As sponsor_name','fieldofficers.name As feild_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('projects')
                ->where('projects.deleted_at', '=', null)
                ->select('projects.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('projects')
                ->where('projects.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('projects.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('projects.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('projects')
                ->where('projects.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('projects.name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('projects.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array['id'] = $SrNo;
          $sub_array['Title'] = '<span>' . wordwrap($item->title, 10, "<br>") . '</span>';
          $sub_array['Start date'] = $item->start_time;
          $sub_array['End date'] = $item->end_time;
          $sub_array['Sponsor'] = '<span>' . wordwrap($item->sponsor_name, 10, "<br>") . '</span>';
          $sub_array['Feildofficer'] = '<span>' . wordwrap($item->feild_name, 10, "<br>") . '</span>';
          $sub_array['village'] = '<span>' . wordwrap($item->village_name, 10, "<br>") . '</span>';
          $sub_array['Latitude'] = $item->latitude;
          $sub_array['Longitude'] = $item->longitude;
          $sub_array['Description'] = '<span>' . wordwrap($item->description, 10, "<br>") . '</span>';

          if ($Role == 1) {
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->title . '_' . $item->start_time . '_' . $item->end_time. '_' . $item->sponsor_id. '_' . $item->field_id. '_' . $item->village_id . '_' .  $item->latitude. '_' . $item->longitude. '_' . $item->description . '" onclick="editProject(this.id);"><i class="fas fa-edit"></i></button><button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteProjects(this.id);"><i class="fas fa-trash"></i></button>';
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
        $ProjectId = $request->ProjectId;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('projects')
            ->where('id', $ProjectId)
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

   public function AdminUpdateProject(Request $request)
   {
       $page = "projects";
       $field_id = $request['id'];
       $input = $request->all();
       $new = Project::findOrFail($field_id);
       $new->update($input);
       return response()->json('Success', 200);
   }

   public function export()
   {
       return Excel::download(new ProjectsExport, 'project.xlsx');
   }
}
