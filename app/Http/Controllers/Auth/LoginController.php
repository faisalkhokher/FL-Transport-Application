<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (isset($user)) {
            if($user->status != 1){
                Auth::logout();
                return redirect('/login')->with('error','Your account has been deactivated. Please contact your manager.');
            }
            else {
                Session::put('user_role', $user->role_id);
                // Update user logged in datetime
                $user->last_logged_in = Carbon::now();
                $user->save();
                // Admin
                if ($user->role_id == 1) {
                    return redirect()->route('adminDashboard');
                }
                // Manager
                if ($user->role_id == 2) {
                    return redirect()->route('readerDashboard');
                }
                // Confirmation Agent
                if ($user->role_id == 3) {
                    return redirect()->route('confirmationAgentDashboard');
                }
                // Supervisor
                if ($user->role_id == 4) {
                    return redirect()->route('supervisorDashboard');
                }
                // Representative
                if ($user->role_id == 5) {
                    return redirect()->route('representativeDashboard');
                }
            }
        }

        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
