<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AdminAllUsers()
    {
        $page = "users";
        $Role = Session::get('user_role');
        return view('admin.users.users', compact('page', 'Role'));
    }

    public function AdminAddNewUsers()
    {
        $page = "users";
        $maxDate = Carbon::now()->subYears(15);
        $maxDate = $maxDate->toDateString();
        $Role = Session::get('user_role');

        // State list
        $states = DB::table('states')
            ->get();

        // Countries list
        $countries = DB::table('countries')
            ->get();

        // Cities list
        $cities = DB::table('cities')
            ->get();

        return view('admin.users.add-new-user', compact('page', 'cities', 'countries', 'states', 'maxDate', 'Role'));
    }

    public function AdminUserStore(Request $request)
    {
        $UserRole = Session::get('user_role');
        $FirstName = $request['firstname'];
        $MiddleName = $request['middlename'];
        $LastName = $request['lastname'];
        $Dob = $request['dob'];
        $Email = $request['email'];
        $Phone = $request['phone'];
        $Phone2 = $request['phone2'];
        $Street = $request['street'];
        $City = $request['city'];
        $State = $request['state'];
        $Country = $request['country'];
        $ZipCode = $request['zipcode'];
        $DocumentName = $request['documentname'];
        $DocumentNumbers = $request['documentnumbers'];
        $Password = rand(10000000, 100000000);
        $Role = 5;
        $UserId = substr($FirstName, 0, 1) . substr($LastName, 0, 1) . rand(10000, 99999);
        $_FileName1 = null;
        $_FileName2 = null;

        if ($request->hasFile('identificationdocument1')) {
            $FileStoragePath = '/public/user-documents/';
            $Extension = $request->file('identificationdocument1')->extension();
            $file = $request->file('identificationdocument1')->getClientOriginalName();
            $FileName = pathinfo($file, PATHINFO_FILENAME);
            $OnlyFileName = $FileName;
            $FileName = $FileName . '-' . date('Y-m-d') . rand(100, 1000) . '.' . $Extension;
            $result = $request->file('identificationdocument1')->storeAs($FileStoragePath, $FileName);
            $_FileName1 = $FileName;
        }

        if ($request->hasFile('identificationdocument2')) {
            $FileStoragePath = '/public/user-documents/';
            $Extension = $request->file('identificationdocument2')->extension();
            $file = $request->file('identificationdocument2')->getClientOriginalName();
            $FileName = pathinfo($file, PATHINFO_FILENAME);
            $OnlyFileName = $FileName;
            $FileName = $FileName . '-' . date('Y-m-d') . rand(100, 1000) . '.' . $Extension;
            $result = $request->file('identificationdocument2')->storeAs($FileStoragePath, $FileName);
            $_FileName2 = $FileName;
        }

        DB::beginTransaction();
        $affected = User::create([
            'userId' => $UserId,
            'email' => $Email,
            'password' => bcrypt($Password),
            'role_id' => $Role,
            'created_at' => Carbon::now(),
        ]);

        $affected1 = Profile::create([
            'user_id' => $affected->id,
            'firstname' => $FirstName,
            'middlename' => $MiddleName,
            'lastname' => $LastName,
            'dob' => $Dob,
            'phone' => $Phone,
            'phone2' => $Phone2,
            'street' => $Street,
            'city' => $City,
            'state' => $State,
            'country' => $Country,
            'zipcode' => $ZipCode,
            'identity1' => $_FileName1,
            'identity2' => $_FileName2,
            'document_name' => $DocumentName,
            'document_numbers' => $DocumentNumbers,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($affected && $affected1) {
            DB::commit();
            if ($UserRole == 1) {
                return redirect(url('/admin/users'))->with('message', 'User has been registered successfully');
            } elseif ($UserRole == 2) {
                return redirect(url('/general_manager/users'))->with('message', 'User has been registered successfully');
            } elseif ($UserRole == 4) {
                return redirect(url('supervisor/add/user'))->with('message', 'User has been registered successfully');
            }
        } else {
            DB::rollback();
            if ($UserRole == 1) {
                return redirect(url('/admin/users'))->with('error', 'Error! An unhandled exception occurred');
            } elseif ($UserRole == 2) {
                return redirect(url('/general_manager/users'))->with('error', 'Error! An unhandled exception occurred');
            } elseif ($UserRole == 4) {
                return redirect(url('supervisor/add/user'))->with('error', 'Error! An unhandled exception occurred');

            }
        }
    }

    public function LoadAdminAllUsers(Request $request)
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
            $fetch_data = DB::table('users')
                ->where('users.deleted_at', '=', null)
                ->where('users.role_id', '!=', 1)
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'users.last_logged_in', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('users')
                ->where('users.deleted_at', '=', null)
                ->where('users.role_id', '!=', 1)
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'users.last_logged_in', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('users')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where(function ($query) {
                    $query->where([
                        ['users.deleted_at', '=', null],
                        ['users.role_id', '!=', 1]
                    ]);
                })
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('users.id', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('roles.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.firstname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.lastname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.dob', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.phone', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.country', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.city', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'users.last_logged_in', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('users')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where(function ($query) {
                    $query->where([
                        ['users.deleted_at', '=', null],
                        ['users.role_id', '!=', 1]
                    ]);
                })
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('users.id', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('roles.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.firstname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.lastname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.dob', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.phone', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.country', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.city', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'users.last_logged_in', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        $status = "";
        $active_ban = "";
        foreach ($fetch_data as $row => $item) {
          if ($Role == 1) {
                  if ($item->status == 1) {
                      $status = '<span class="badge badge-success">Active</span>';
                      if ($item->last_logged_in != "") {
                        $status .= "<br><br>" . Carbon::parse($item->last_logged_in)->format('m/d/Y - g:i a');
                      }
                      $active_ban = '<button class="btn btn-danger mr-2" id="ban_' . $item->id . '" onclick="banUser(this.id);"><i class="fas fa-ban"></i></button>';
                  } else {
                      $status = '<span class="badge badge-danger">Ban</span>';
                      if ($item->last_logged_in != "") {
                        $status .= "<br><br>" . Carbon::parse($item->last_logged_in)->format('m/d/Y - g:i a');
                      }
                      $active_ban = '<button class="btn btn-success mr-2" id="active_' . $item->id . '" onclick="activeUser(this.id);"><i class="fas fa-check"></i></button>';
                  }
              }
              $Phone_Email = "";
              $Phone_Email .= "<b><a href='tel: " . $item->phone . "' style='color: black;'>" . $item->phone . "</a></b><br><br>";
              $Phone_Email .= "<a href='mailto:" . $item->email . "' style='color: black;'>" . $item->email . "</a><br><br>";
              $Phone_Email .= "<span class='text-black'>" . $item->city . ", " . $item->country . "</span>";
              $sub_array = array();
              $sub_array['id'] = $SrNo;
              $sub_array['user_information'] = '<span>' . wordwrap("<strong>" . $item->firstname . " " . $item->lastname . "</strong><br><br>" . $item->userId . "<br><br>" . $item->role, 30, '<br>') . '</span>';
              $sub_array['contact'] = '<span>' . $Phone_Email . '</span>';
              $sub_array['status'] = $status;
              if ($Role == 1) {
                  $sub_array['action'] = $active_ban . '<button class="btn greenActionButtonTheme mr-2" id="changePassword_' . $item->id . '" onclick="ChangePassword(this);"><i class="fas fa-user-lock"></i></button><button class="btn greenActionButtonTheme mr-2" id="edit_' . $item->id . '" onclick="editUser(this.id);"><i class="fas fa-edit"></i></button><button class="btn greenActionButtonTheme mr-2" id="delete_' . $item->id . '" onclick="deleteUser(this.id);"><i class="fas fa-trash"></i></button>';
              } else {
                  $sub_array['action'] = $active_ban . '<button class="btn greenActionButtonTheme mr-2" id="changePassword_' . $item->id . '" onclick="ChangePassword(this);"><i class="fas fa-user-lock"></i></button><button class="btn greenActionButtonTheme mr-2" id="edit_' . $item->id . '" onclick="editManagerUser(this.id);"><i class="fas fa-edit"></i></button>';
              }
              $SrNo++;
              $data[] = $sub_array;
        }

        $json_data = array(
            "draw" => intval($request->post('draw')),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsFiltered,
            "aaData" => $data
        );

        echo json_encode($json_data);
    }

    public function CalculateUserProgress($user_id)
    {
        $UserProgress = 0;
        //Total User Assigned Leads
        $TotalAssignedLeads = DB::table('lead_assignments')
            ->where('user_id', $user_id)
            ->count();

        if ($TotalAssignedLeads > 0) {
            // Total User Completed Leads
            $TotalCompletedAssignedLeads = DB::table('lead_assignments')
                ->where('user_id', $user_id)
                ->where('status', '=', 1)
                ->count();

            $UserProgress = (($TotalCompletedAssignedLeads / $TotalAssignedLeads) * 100);
            return '<span class="badge badge-primary pl-2 pr-2">' . bcdiv($UserProgress, 1, 0) . '%</span>';
        } else {
            return '';
        }
    }

    public function AdminDeleteUser(Request $request)
    {
        $Role = Session::get('user_role');
        $user_id = $request['id'];
        DB::beginTransaction();
        $affected = DB::table('users')
            ->where('id', $user_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
            DB::commit();
            if ($Role == 1) {
                return redirect(url('/admin/users'))->with('message', 'User has been deleted successfully');
            } elseif ($Role == 2) {
                return redirect(url('/general_manager/users'))->with('message', 'User has been deleted successfully');
            }
        } else {
            DB::rollback();
            if ($Role == 1) {
                return redirect(url('/admin/users'))->with('error', 'Error! An unhandled exception occurred');
            } elseif ($Role == 2) {
                return redirect(url('/general_manager/users'))->with('error', 'Error! An unhandled exception occurred');
            }
        }
    }

    public function AdminEditUser(Request $request)
    {
        $Role = Session::get('user_role');
        $page = "users";
        $user_id = $request['id'];
        $user_details = DB::table('users')
            ->join('profiles', 'profiles.user_id', '=', 'users.id')
            ->where('users.id', $user_id)
            ->where('users.deleted_at', '=', null)
            ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'users.role_id AS role', 'profiles.firstname AS firstname', 'profiles.middlename AS middlename', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.phone2 AS phone2', 'profiles.state AS state', 'profiles.country AS country', 'profiles.city AS city', 'profiles.street AS street', 'profiles.zipcode AS zipcode', 'profiles.identity1 AS identity1', 'profiles.identity2 AS identity2', 'profiles.document_name AS document_name', 'profiles.document_numbers AS document_numbers')
            ->get();

        $role_details = DB::table('roles')
            ->where('deleted_at', '=', null)
            ->get();

        $maxDate = Carbon::now()->subYears(15);
        $maxDate = $maxDate->toDateString();

        // States list
        $states = DB::table('states')
            ->get();
        // Countries list
        $countries = DB::table('countries')
            ->get();

        // Cities list
        $cities = DB::table('cities')
            ->get();

        return view('admin.users.edit-user', compact('page', 'cities', 'countries', 'states', 'user_id', 'user_details', 'role_details', 'maxDate', 'Role'));
    }

    public function AdminUpdateUser(Request $request)
    {
        $UserRole = Session::get('user_role');
        $user_id = $request['id'];
        $FirstName = $request['firstname'];
        $MiddleName = $request['middlename'];
        $LastName = $request['lastname'];
        $Dob = $request['dob'];
        $Email = $request['email'];
        $Phone = $request['phone'];
        $Phone2 = $request['phone2'];
        $Street = $request['street'];
        $City = $request['city'];
        $State = $request['state'];
        $Country = $request['country'];
        $ZipCode = $request['zipcode'];
        $DocumentName = $request['documentname'];
        $DocumentNumbers = $request['documentnumbers'];
        $Role = $request['role'];
        $_FileName1 = $request['identity1_Old'];
        $_FileName2 = $request['identity2_Old'];

        if ($request->hasFile('identificationdocument1')) {
            if ($request['identity1_Old'] != "") {
                unlink(base_path() . '/public/storage/user-documents/' . $request['identity1_Old']);
            }
            $FileStoragePath = '/public/user-documents/';
            $Extension = $request->file('identificationdocument1')->extension();
            $file = $request->file('identificationdocument1')->getClientOriginalName();
            $FileName = pathinfo($file, PATHINFO_FILENAME);
            $OnlyFileName = $FileName;
            $FileName = $FileName . '-' . date('Y-m-d') . rand(100, 1000) . '.' . $Extension;
            $result = $request->file('identificationdocument1')->storeAs($FileStoragePath, $FileName);
            $_FileName1 = $FileName;
        }

        if ($request->hasFile('identificationdocument2')) {
            if ($request['identity2_Old'] != "") {
                unlink(base_path() . '/public/storage/user-documents/' . $request['identity2_Old']);
            }
            $FileStoragePath = '/public/user-documents/';
            $Extension = $request->file('identificationdocument2')->extension();
            $file = $request->file('identificationdocument2')->getClientOriginalName();
            $FileName = pathinfo($file, PATHINFO_FILENAME);
            $OnlyFileName = $FileName;
            $FileName = $FileName . '-' . date('Y-m-d') . rand(100, 1000) . '.' . $Extension;
            $result = $request->file('identificationdocument2')->storeAs($FileStoragePath, $FileName);
            $_FileName2 = $FileName;
        }

        DB::beginTransaction();
        if ($UserRole == 1) {
            $affected = DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'email' => $Email,
                    'role_id' => $Role,
                    'updated_at' => Carbon::now(),
                ]);

            $affected1 = DB::table('profiles')
                ->where('user_id', $user_id)
                ->update([
                    'firstname' => $FirstName,
                    'middlename' => $MiddleName,
                    'lastname' => $LastName,
                    'dob' => $Dob,
                    'phone' => $Phone,
                    'phone2' => $Phone2,
                    'street' => $Street,
                    'city' => $City,
                    'state' => $State,
                    'country' => $Country,
                    'zipcode' => $ZipCode,
                    'identity1' => $_FileName1,
                    'identity2' => $_FileName2,
                    'document_name' => $DocumentName,
                    'document_numbers' => $DocumentNumbers,
                    'updated_at' => Carbon::now(),
                ]);
        } else {
            $affected1 = DB::table('profiles')
                ->where('user_id', $user_id)
                ->update([
                    'phone' => $Phone,
                    'phone2' => $Phone2,
                    'street' => $Street,
                    'city' => $City,
                    'state' => $State,
                    'country' => $Country,
                    'zipcode' => $ZipCode,
                    'identity1' => $_FileName1,
                    'identity2' => $_FileName2,
                    'document_name' => $DocumentName,
                    'document_numbers' => $DocumentNumbers,
                    'updated_at' => Carbon::now(),
                ]);
        }

        DB::commit();
        if ($UserRole == 1) {
            return redirect(url('/admin/users'))->with('message', 'User record has been updated successfully');
        } elseif ($UserRole == 2) {
            return redirect(url('/general_manager/users'))->with('message', 'User record has been updated successfully');
        }
    }

    function ChangePassword(Request $request)
    {
        $UserRole = Session::get('user_role');
        $UserId = $request->post('user_id');
        $Password = $request->post('newPassword');
        DB::beginTransaction();
        DB::table('users')->where('id', '=', $UserId)->update([
            'password' => bcrypt($Password),
            'updated_at' => Carbon::now()
        ]);
        DB::commit();

        if ($UserRole == 1) {
            return redirect(url('/admin/users'))->with('message', 'User Password has been updated successfully');
        } elseif ($UserRole == 2) {
            return redirect(url('/general_manager/users'))->with('message', 'User Password has been updated successfully');
        }
    }

    function EditProfile()
    {
        $page = 'dashboard';
        $Role = Session::get('user_role');
        $Profile = DB::table('profiles')->where('user_id', '=', Auth::id())->get();
        return view('admin.profile', compact('page', 'Role', 'Profile'));
    }

    function UpdatePersonalDetails(Request $request)
    {
        $UserRole = Session::get('user_role');
        $FirstName = $request['firstName'];
        $MiddleName = $request['middleName'];
        $LastName = $request['lastName'];
        $DOB = $request['dob'];
        $Phone = $request['phone'];
        $Phone2 = $request['phone2'];
        $Country = $request['country'];
        $Street = $request['street'];
        $City = $request['city'];
        $State = $request['state'];
        $Country = $request['country'];
        $ZipCode = $request['zipcode'];
        $OldProfilePicture = $request['oldProfilePicture'];
        $NewProfilePicture = "";

        if ($request->file('userProfileUpdate')) {
            // Removing Old File if Exists
            if ($OldProfilePicture != '' && $OldProfilePicture != null) {
                unlink(base_path() . '/public/storage/profile-pics/' . $OldProfilePicture);
            }
            //Storing new file
            $Filename = substr($FirstName, 0, 1) . substr($LastName, 0, 1);
            $Extension = $request->file('userProfileUpdate')->extension();
            $Filename = $Filename . '-' . mt_rand(1000000, 9999999) . '.' . $Extension;
            $NewProfilePicture = $Filename;
            $result = $request->file('userProfileUpdate')->storeAs('/public/profile-pics/', $Filename);
        } else {
            $NewProfilePicture = $OldProfilePicture;
        }

        if ($UserRole == 1) {
            DB::beginTransaction();
            DB::table('profiles')
                ->where('user_id', '=', Auth::id())
                ->update([
                    'firstname' => $FirstName,
                    'middlename' => $MiddleName,
                    'lastname' => $LastName,
                    'dob' => $DOB,
                    'phone' => $Phone,
                    'phone2' => $Phone2,
                    'street' => $Street,
                    'city' => $City,
                    'state' => $State,
                    'country' => $Country,
                    'zipcode' => $ZipCode,
                    'profile_picture' => $NewProfilePicture,
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
        } else {
            DB::beginTransaction();
            DB::table('profiles')
                ->where('user_id', '=', Auth::id())
                ->update([
                    'phone' => $Phone,
                    'phone2' => $Phone2,
                    'street' => $Street,
                    'city' => $City,
                    'state' => $State,
                    'country' => $Country,
                    'zipcode' => $ZipCode,
                    'profile_picture' => $NewProfilePicture,
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
        }

        if ($UserRole == 1) {
            return redirect(url('/admin/edit-profile'))->with('message', 'Personal Details has been updated successfully');
        } elseif ($UserRole == 2) {
            return redirect(url('/reader/edit-profile'))->with('message', 'Personal Details has been updated successfully');
        }
    }

    function UpdateAccountSecurity(Request $request)
    {
        $UserId = $request->post('user_id');
        $Password = $request->post('newPassword');
        DB::beginTransaction();
        DB::table('users')->where('id', '=', $UserId)->update([
            'password' => bcrypt($Password),
            'updated_at' => Carbon::now()
        ]);
        DB::commit();

        return redirect(url('logout'))->with('message', 'User Password has been updated successfully. Please login again with new password.');
    }

    public function ban(Request $request)
    {
        $id = $request->post('UserId');
        DB::beginTransaction();
        $affected = DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
        if ($affected) {
            DB::commit();
            echo "Success";
        } else {
            DB::rollback();
            echo "Failed";
        }
    }

    public function active(Request $request)
    {
        $id = $request->post('UserId');
        DB::beginTransaction();
        $affected = DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        if ($affected) {
            DB::commit();
            echo "Success";
        } else {
            DB::rollback();
            echo "Failed";
        }
    }

    public function UsersProgress()
    {
        $page = "usersProgress";
        return view('admin.users.progress', compact('page'));
    }

    public function UsersProgressAll(Request $request){
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
            $fetch_data = DB::table('users')
                ->where('users.deleted_at', '=', null)
                ->where('users.role_id', '!=', 1)
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'profiles.facebook AS facebook', 'profiles.bank_account_number AS bank_account_number', 'profiles.bank_name AS bank_name', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('users')
                ->where('users.deleted_at', '=', null)
                ->where('users.role_id', '!=', 1)
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'profiles.facebook AS facebook', 'profiles.bank_account_number AS bank_account_number', 'profiles.bank_name AS bank_name', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('users')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where(function ($query) {
                    $query->where([
                        ['users.deleted_at', '=', null],
                        ['users.role_id', '!=', 1]
                    ]);
                })
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('users.id', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('roles.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.firstname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.lastname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.dob', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.phone', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.country', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.city', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.facebook', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.bank_account_number', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.bank_name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'profiles.facebook AS facebook', 'profiles.bank_account_number AS bank_account_number', 'profiles.bank_name AS bank_name', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('users')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where(function ($query) {
                    $query->where([
                        ['users.deleted_at', '=', null],
                        ['users.role_id', '!=', 1]
                    ]);
                })
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('users.id', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('roles.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.firstname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.lastname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.dob', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.phone', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.country', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.city', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.facebook', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.bank_account_number', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.bank_name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('users.id AS id', 'users.userId AS userId', 'users.email AS email', 'roles.title as role', 'profiles.firstname AS firstname', 'profiles.lastname AS lastname', 'profiles.dob AS dob', 'profiles.phone AS phone', 'profiles.country AS country', 'profiles.city AS city', 'profiles.facebook AS facebook', 'profiles.bank_account_number AS bank_account_number', 'profiles.bank_name AS bank_name', 'users.status')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        $status = "";
        $active_ban = "";
        foreach ($fetch_data as $row => $item) {
            $Progress = $this->CalculateUserProgress($item->id);
            if($Progress != ""){
                $sub_array = array();
                $sub_array['id'] = $SrNo;
                $sub_array['role'] = $item->role;
                $sub_array['userId'] = $item->userId;
                $sub_array['name'] = $item->firstname . " " . $item->lastname;
                $sub_array['progress'] = $this->CalculateUserProgress($item->id);
                $SrNo++;
                $data[] = $sub_array;
            }
        }

        $json_data = array(
            "draw" => intval($request->post('draw')),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsFiltered,
            "aaData" => $data
        );

        echo json_encode($json_data);
    }
}
