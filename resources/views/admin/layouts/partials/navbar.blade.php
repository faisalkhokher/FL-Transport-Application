<nav class="navbar">
    <a href="#" class="sidebar-toggler" id="toggleSidebar" style="visibility: hidden;">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            <!-- <li class="nav-item dropdown nav-notifications">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    <div class="indicator">
                        <div class="circle"></div>
                    </div>
                </a>
                <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium">6 New Notifications</p>
                        <a href="javascript:void(0);" class="text-muted">Clear all</a>
                    </div>
                    <div class="dropdown-body">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="icon">
                                <i data-feather="user-plus"></i>
                            </div>
                            <div class="content">
                                <p>New customer registered</p>
                                <p class="sub-text text-muted">2 sec ago</p>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="icon">
                                <i data-feather="gift"></i>
                            </div>
                            <div class="content">
                                <p>New Order Recieved</p>
                                <p class="sub-text text-muted">30 min ago</p>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="icon">
                                <i data-feather="alert-circle"></i>
                            </div>
                            <div class="content">
                                <p>Server Limit Reached!</p>
                                <p class="sub-text text-muted">1 hrs ago</p>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="icon">
                                <i data-feather="layers"></i>
                            </div>
                            <div class="content">
                                <p>Apps are ready for update</p>
                                <p class="sub-text text-muted">5 hrs ago</p>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="icon">
                                <i data-feather="download"></i>
                            </div>
                            <div class="content">
                                <p>Download completed</p>
                                <p class="sub-text text-muted">6 hrs ago</p>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);">View all</a>
                    </div>
                </div>
            </li> -->
            @php
                $Profile = \Illuminate\Support\Facades\DB::table('profiles')->where('user_id', '=', \Illuminate\Support\Facades\Auth::id())->get();
                $ProfilePic = asset('public/storage/profile-pics/admin_12345.jpg');
                if($Profile[0]->profile_picture != null){
                    $ProfilePic = asset('public/storage/profile-pics') . '/' . $Profile[0]->profile_picture;
                }
                $Name = $Profile[0]->firstname . " " . $Profile[0]->lastname;
            @endphp
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{$ProfilePic}}" alt="profile">
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{$ProfilePic}}" alt="">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{$Name}}</p>
                            <p class="email text-muted mb-3">{{\Illuminate\Support\Facades\Auth::user()->email}}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            @if(Illuminate\Support\Facades\Session::get('user_role') == 1)
                                <li class="nav-item">
                                    <a href="{{url('admin/edit-profile')}}" class="nav-link">
                                        <i data-feather="edit"></i>
                                        <span>Edit Profile</span>
                                    </a>
                                </li>
                            @elseif(Illuminate\Support\Facades\Session::get('user_role') == 2)
                                <li class="nav-item">
                                    <a href="{{url('reader/edit-profile')}}" class="nav-link">
                                        <i data-feather="edit"></i>
                                        <span>Edit Profile</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i data-feather="log-out"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
