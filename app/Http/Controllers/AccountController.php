<?php

namespace App\Http\Controllers;

use App\User;
use App\Roles;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function index()
    {
        $page = "accounts";
        $accounts = User::all();
        $roles = Roles::all();
        $roles = json_encode($roles);
        return view('admin.accounts.index', compact('page', 'roles'));
    }

    function add(){
        $page = "accounts";
        $roles = Roles::all();
        return view('admin.accounts.add-account', compact('page', 'roles'));
    }

    function store(Request $request){
        $Email = $request->post('email');
        $Password = $request->post('password');
        $Role = $request->post('role_id');
        $Status = $request->post('status');
        $FirstName = $request->post('firstName');
        $MiddleName = $request->post('middleName');
        $LastName = $request->post('lastName');
        $Dob = $request->post('dob');
        $Phone = $request->post('phone');
        $Phone2 = $request->post('phone2');
        $Street = $request->post('street');
        $City = $request->post('city');
        $State = $request->post('state');
        $Country = $request->post('country');
        $Zipcode = $request->post('zipcode');
        $ProfilePicture = "";

        // userProfileUpdate
        if ($request->file('profile_picture')) {
            $Filename = Carbon::now()->format('Y-m-d H:i:s');
            $Extension = $request->file('profile_picture')->extension();
            $Filename = $Filename . '-' . mt_rand(1000000, 9999999) . '.' . $Extension;
            $ProfilePicture = $Filename;
            $result = $request->file('profile_picture')->storeAs('/public/profile-pics/', $Filename);
        }

        DB::beginTransaction();
        $Affected1 = User::create([
            'userId' => '',
            'email' => $Email,
            'password' => bcrypt($Password),
            'role_id' => $Role,
            'status' => $Status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $Affected2 = Profile::create([
            'user_id' => $Affected1->id,
            'firstname' => $FirstName,
            'middlename' => $MiddleName,
            'lastname' => $LastName,
            'dob' => $Dob,
            'phone' => $Phone,
            'phone2' => $Phone2,
            'country' => $Country,
            'city' => $City,
            'street' => $Street,
            'state' => $State,
            'zipcode' => $Zipcode,
            'profile_picture' => $ProfilePicture,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::commit();
        return redirect(url('/admin/accounts'))->with('message', 'Account created successfully!');
    }

    function edit($Id){
        $User = DB::table('users')
            ->where('id', '=', $Id)
        ->get();

        $Profile = DB::table('profiles')
            ->where('user_id', '=', $Id)
            ->get();
        $page = "accounts";
        $roles = Roles::all();
        return view('admin.accounts.edit-account', compact('page', 'roles', 'User', 'Profile'));
    }

    function update(Request $request){
        $UserId = $request->post('id');
        $Email = $request->post('email');
        $Password = $request->post('password');
        $Role = $request->post('role_id');
        $Status = $request->post('status');
        $FirstName = $request->post('firstName');
        $MiddleName = $request->post('middleName');
        $LastName = $request->post('lastName');
        $Dob = $request->post('dob');
        $Phone = $request->post('phone');
        $Phone2 = $request->post('phone2');
        $Street = $request->post('street');
        $City = $request->post('city');
        $State = $request->post('state');
        $Country = $request->post('country');
        $Zipcode = $request->post('zipcode');
        $OldProfilePicture = $request->post('oldProfilePicture');
        $ProfilePicture = "";
        $FileStoragePath = '/public/profile-pics/';

        // userProfileUpdate
        if ($request->file('profile_picture')) {
            if ($OldProfilePicture != '' && $OldProfilePicture != null) {
                unlink(base_path() . '/public/storage/profile-pics/' . $OldProfilePicture);
            }
            $Filename = Carbon::now()->format('YmdHis');
            $Extension = $request->file('profile_picture')->extension();
            $Filename = $Filename . '-' . mt_rand(1000000, 9999999) . '.' . $Extension;
            $ProfilePicture = $Filename;
            $result = $request->file('profile_picture')->storeAs($FileStoragePath, $Filename);
        }else{
            $ProfilePicture = $OldProfilePicture;
        }

        DB::beginTransaction();
        if($Password != ''){
            DB::table('users')
                ->where('id', '=', $UserId)
                ->update([
                    'email' => $Email,
                    'password' => bcrypt($Password),
                    'role_id' => $Role,
                    'status' => $Status,
                    'updated_at' => Carbon::now()
                ]);
        }
        else{
            DB::table('users')
                ->where('id', '=', $UserId)
                ->update([
                    'email' => $Email,
                    'role_id' => $Role,
                    'status' => $Status,
                    'updated_at' => Carbon::now()
                ]);
        }

        DB::table('profiles')
            ->where('user_id', '=', $UserId)
            ->update([
                'firstname' => $FirstName,
                'middlename' => $MiddleName,
                'lastname' => $LastName,
                'dob' => $Dob,
                'phone' => $Phone,
                'phone2' => $Phone2,
                'country' => $Country,
                'city' => $City,
                'street' => $Street,
                'state' => $State,
                'zipcode' => $Zipcode,
                'profile_picture' => $ProfilePicture,
                'updated_at' => Carbon::now()
            ]);

        DB::commit();
        return redirect(url('/admin/accounts'))->with('message', 'Account updated successfully!');
    }

    public function LoadAccounts(Request $request)
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
                ->join('profiles', 'users.id', '=', 'profiles.user_id')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('users.deleted_at', '=', null)
                ->select('users.*', 'profiles.firstname As firstname', 'profiles.middlename As middlename', 'profiles.lastname As lastname', 'profiles.dob As dob', 'profiles.phone2 As phone2', 'profiles.country As country', 'profiles.city As city', 'profiles.street As street',
                    'profiles.state As state', 'profiles.zipcode As zipcode', 'profiles.profile_picture As profile_picture', 'roles.title As role_name', 'profiles.phone As phoneone')
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('users')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.deleted_at', '=', null)
                ->select('users.*', 'profiles.firstname As firstname', 'profiles.middlename As middlename', 'profiles.lastname As lastname', 'profiles.dob As dob', 'profiles.phone2 As phone2', 'profiles.country As country', 'profiles.city As city', 'profiles.street As street',
                    'profiles.state As state', 'profiles.zipcode As zipcode', 'profiles.profile_picture As profile_picture', 'roles.title As role_name', 'profiles.phone As phoneone')
                ->count();
        } else {
            $fetch_data = DB::table('users')
                ->where('users.deleted_at', '=', null)
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('profiles.firstname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.middlename', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.middlename', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('roles.title', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('users.*', 'profiles.firstname As firstname', 'profiles.middlename As middlename', 'profiles.lastname As lastname', 'profiles.dob As dob', 'profiles.phone2 As phone2', 'profiles.country As country', 'profiles.city As city', 'profiles.street As street',
                    'profiles.state As state', 'profiles.zipcode As zipcode', 'profiles.profile_picture As profile_picture', 'roles.title As role_name', 'profiles.phone As phoneone')
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('users')
                ->where('users.deleted_at', '=', null)
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('profiles.firstname', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.middlename', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('profiles.middlename', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('roles.title', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('users.*', 'profiles.firstname As firstname', 'profiles.middlename As middlename', 'profiles.lastname As lastname', 'profiles.dob As dob', 'profiles.phone2 As phone2', 'profiles.country As country', 'profiles.city As city', 'profiles.street As street',
                    'profiles.state As state', 'profiles.zipcode As zipcode', 'profiles.profile_picture As profile_picture', 'roles.title As role_name', 'profiles.phone As phoneone')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;

        foreach ($fetch_data as $row => $item) {
            $Name = $item->firstname . " " . $item->middlename . " " . $item->lastname;
            $sub_array = array();
            $sub_array['id'] = $SrNo;
            $sub_array['name'] = '<span>' . wordwrap($Name, 30, "<br>") . '</span>';
            $sub_array['email'] = $item->email;
            $sub_array['role'] = $item->role_name;
            $sub_array['logged_in'] = Carbon::parse($item->last_logged_in)->format('Y-m-d g:i a');
            if ($item->status == 0) {
                $sub_array['status'] = '<span class="badge badge-danger">Ban</span>';
            } else {
                $sub_array['status'] = '<span class="badge badge-success">Active</span>';
            }
            $Url = url('admin/accounts/edit/') . "/" . $item->id;
            $sub_array['action'] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '_' . $item->firstname . '_' . $item->middlename . '_' . $item->lastname . '_' . $item->dob . '_' . $item->phone2 . '_' . $item->country . '_' . $item->city . '_' . $item->street . '_' . $item->state . '_' . $item->zipcode . '_' . $item->role_id . '_' . $item->status . '_' . $item->email . '_' . $item->phoneone . '" onclick="window.location.href=\'' . $Url . '\';"><i class="fas fa-edit"></i></button><button class="btn btn-danger mr-2" id="delete_' . $item->id . '" onclick="deleteAccount(this.id);"><i class="fas fa-trash"></i></button>';
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

    public function AdminStoreAmbulance(ProfileRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->last_logged_in = Carbon::now();
        if ($request->status == 1) {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->save();
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->firstName = $request->firstName;
        $profile->middleName = $request->middleName;
        $profile->lastName = $request->lastName;
        $profile->dob = $request->dob;
        $profile->phone = $request->phone;
        $profile->phone2 = $request->phone2;
        $profile->street = $request->street;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->country = $request->country;
        $profile->zipcode = $request->zipcode;
        $profile->profile_picture = $request->profile_picture;
        if ($file = $request->file('profile_picture')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('public/storage/profile-pics', $name);
            $profile->profile_picture = $name;
        }
        $profile->save();
        return response()->json("Saved");
    }

    public function delete(Request $request)
    {
        $AccountId = $request->AccountId;
        $affected = null;
        DB::beginTransaction();
        $affected = DB::table('users')
            ->where('id', $AccountId)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        if ($affected) {
            DB::commit();
            echo "Success";
        } else {
            DB::rollback();
            echo "Error";
        }
    }

    public function UpdateAccount(Request $request)
    {
        $id = $request['id'];
        $user = User::find($id);
        if ($request->email) {
            $user->email = $request->email;
        } else {
            $user->email = $user->email;
        }
        $user->role_id = $request->role_id;
        $user->last_logged_in = Carbon::now();
        if ($request->password) {
            $user->password = bcrypt($request->password);
        } else {
            $user->password = $user->password;
        }
        if ($request->status == 1) {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->save();
        $profile = Profile::where('user_id', $id)->first();
        $profile->user_id = $user->id;
        $profile->firstName = $request->firstName;
        $profile->middleName = $request->middleName;
        $profile->lastName = $request->lastName;
        $profile->dob = $request->dob;
        $profile->phone = $request->phone;
        $profile->phone2 = $request->phone2;
        $profile->street = $request->street;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->country = $request->country;
        $profile->zipcode = $request->zipcode;
        if ($file = $request->file('profile_picture')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('public/storage/profile-pics', $name);
            $profile->profile_picture = $name;
        }
        $profile->save();
        return response()->json("Updated");
    }
}
