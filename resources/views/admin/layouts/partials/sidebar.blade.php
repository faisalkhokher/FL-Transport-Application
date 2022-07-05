<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <img src="{{ asset('public/storage/logo/app_logo.jpeg') }}" alt="logo-small"
                style="width: 150px; height: 35px;">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            {{-- Admin User --}}
            @if (Session::get('user_role') == 1)
                <li class="nav-item nav-category">Main</li>
                @if ($page == 'dashboard')
                    <li class="nav-item active">
                        <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item nav-category">Data</li>

                <li class="nav-item">
                    <a href="{{ route('admin.field-officers') }}" class="nav-link">
                        <i class="link-icon" data-feather="users"></i>
                        <span class="link-title">Field Officers</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.sponsors') }}" class="nav-link">
                        <i class="link-icon" data-feather="user-plus"></i>
                        <span class="link-title">Sponsors</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.countries') }}" class="nav-link">
                        <i class="link-icon" data-feather="map-pin"></i>
                        <span class="link-title">Countries</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.districts') }}" class="nav-link">
                        <i class="link-icon" data-feather="database"></i>
                        <span class="link-title">Districts</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.villages') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Villages</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.workplaces') }}" class="nav-link">
                        <i class="link-icon" data-feather="airplay"></i>
                        <span class="link-title">Work Places</span>
                    </a>
                </li>
                {{-- @endif --}}

                <li class="nav-item nav-category">Administration</li>

                @if ($page == 'accounts')
                    <li class="nav-item active">
                        <a href="{{ route('index.accounts') }}" class="nav-link">
                            <i class="link-icon" data-feather="lock"></i>
                            <span class="link-title">Accounts</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('index.accounts') }}" class="nav-link">
                            <i class="link-icon" data-feather="lock"></i>
                            <span class="link-title">Accounts</span>
                        </a>
                    </li>
                @endif
            @endif
            {{-- Admin User --}}



            {{-- Reader User --}}
            @if (Session::get('user_role') == 2)


            @if ($page == 'dashboard')
            <li class="nav-item active">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            @else
            <li class="nav-item">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
             @endif



             <li class="nav-item nav-category">Data</li>

             <li class="nav-item">
                 <a href="{{ route('reader.field-officers') }}" class="nav-link">
                     <i class="link-icon" data-feather="users"></i>
                     <span class="link-title">Field Officers</span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="{{ route('reader.sponsors') }}" class="nav-link">
                     <i class="link-icon" data-feather="user-plus"></i>
                     <span class="link-title">Sponsors</span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="{{ route('reader.countries') }}" class="nav-link">
                     <i class="link-icon" data-feather="map-pin"></i>
                     <span class="link-title">Countries</span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="{{ route('reader.districts') }}" class="nav-link">
                     <i class="link-icon" data-feather="database"></i>
                     <span class="link-title">Districts</span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="{{ route('reader.villages') }}" class="nav-link">
                     <i class="link-icon" data-feather="home"></i>
                     <span class="link-title">Villages</span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="{{ route('reader.workplaces') }}" class="nav-link">
                     <i class="link-icon" data-feather="airplay"></i>
                     <span class="link-title">Work Places</span>
                 </a>
             </li>
             {{-- @endif --}}
            @endif
        </ul>
    </div>
</nav>
