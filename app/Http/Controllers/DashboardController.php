<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Project;
use App\Prospect;
use App\Sponsor;
use App\Village;
use App\Ambulance;
use App\WorkPlace;
use Carbon\Carbon;
use App\Wheelchair;
use App\Fieldofficer;
use App\AmbulanceUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $Role = Session::get('user_role');

    if ($Role == 1) {
      return redirect()->route('adminDashboard');
    } elseif ($Role == 2) {
      return redirect()->route('readerDashboard');
    }
  }

  public function LoadDashboard()
  {
    $page = "dashboard";
    $Role = Session::get('user_role');

    $villages = Village::all();
    $villages = json_encode($villages);
    $feildoffers = Fieldofficer::all();
    $feildoffers = json_encode($feildoffers);
    $sponsors = Sponsor::all();
    $sponsors = json_encode($sponsors);
    $ambulances = Ambulance::all();
    $ambulances = json_encode($ambulances);
    $workplaces = WorkPlace::all();
    $workplaces = json_encode($workplaces);

    // Collect data for google maps
    $ambulance_markers = Ambulance::where('deleted_at', '=', null)->get();
    $wheelchair_markers = Wheelchair::where('deleted_at', '=', null)->get();
    $projects_markers = Project::where('deleted_at', '=', null)->get();
    $prospect_markers = Prospect::where('deleted_at', '=', null)->get();
    $AmbulanceUsageMap_markers = AmbulanceUsage::where('deleted_at', '=', null)->get();

    return view('admin.index', compact('page','villages','sponsors','feildoffers','workplaces','ambulance_markers','wheelchair_markers','projects_markers','prospect_markers','ambulances','AmbulanceUsageMap_markers'));
 }

 public function GetAllAmbulances(Request $request)
 {
   $ambulance_markers = Ambulance::where('deleted_at', '=', null)->get();
   echo json_encode($ambulance_markers);
 }

 public function GetAllWheelchairs(Request $request)
 {
   $wheelchair_markers = Wheelchair::where('deleted_at', '=', null)->get();
   echo json_encode($wheelchair_markers);
 }

 public function GetAllProjects(Request $request)
 {
   $projects_markers = Project::where('deleted_at', '=', null)->get();
   echo json_encode($projects_markers);
 }

 public function GetAllProspects(Request $request)
 {
   $prospect_markers = Prospect::where('deleted_at', '=', null)->get();
   echo json_encode($prospect_markers);
 }

 public function SupervisorDashboard(Request $request)
 {
    $page = "dashboard";
    $Role = Session::get('user_role');
    $user_id = Auth::id();

    $products = DB::table('products')
    ->where('deleted_at', '=', null)
    ->get();

    $companies = DB::table('buissness_accounts')
    ->where('deleted_at', '=', null)
    ->get();

    $SplitOptions = DB::table('users')
    ->join('profiles', 'users.id', '=', 'profiles.user_id')
    ->whereIn('users.role_id', array(4, 5))
    ->where('users.deleted_at', '=', null)
    ->where('users.id', '<>', $user_id)
    ->select('users.*', 'profiles.firstname', 'profiles.lastname')
    ->get();

    $TeamId = 0;
    if ($Role == 5) {
      $TeamsSql = "SELECT * FROM teams WHERE (FIND_IN_SET(:userId, members) > 0) AND ISNULL(deleted_at);";
      $Team = DB::select(DB::raw($TeamsSql), array($user_id));
      $TeamId = 0;
      foreach ($Team as $item) {
        $TeamId = $item->id;
      }
    } else {
      $TeamId = 0;
    }

    $states = DB::table('states')->get();

    return view('admin.lead.add-new-lead', compact('page', 'products', 'companies', 'TeamId', 'SplitOptions', 'Role', 'states'));
  }

  public function RepresentativeDashboard(Request $request)
  {
    $page = "dashboard";
    $Role = Session::get('user_role');
    $user_id = Auth::id();

    $products = DB::table('products')
    ->where('deleted_at', '=', null)
    ->get();

    $companies = DB::table('buissness_accounts')
    ->where('deleted_at', '=', null)
    ->get();

    $SplitOptions = DB::table('users')
    ->join('profiles', 'users.id', '=', 'profiles.user_id')
    ->whereIn('users.role_id', array(4, 5))
    ->where('users.deleted_at', '=', null)
    ->where('users.id', '<>', $user_id)
    ->select('users.*', 'profiles.firstname', 'profiles.lastname')
    ->get();

    $TeamId = 0;
    if ($Role == 5) {
      $TeamsSql = "SELECT * FROM teams WHERE (FIND_IN_SET(:userId, members) > 0) AND ISNULL(deleted_at);";
      $Team = DB::select(DB::raw($TeamsSql), array($user_id));
      $TeamId = 0;
      foreach ($Team as $item) {
        $TeamId = $item->id;
      }
    } else {
      $TeamId = 0;
    }

    $states = DB::table('states')
    ->get();

    return view('admin.lead.add-new-lead', compact('page', 'products', 'companies', 'TeamId', 'SplitOptions', 'Role', 'states'));
  }
}
