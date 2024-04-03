<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                <input type="hidden" class="bearer-token">
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @role('admin')
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link @yield('dashboard')">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- End Dashboard --}}
                @endrole
                {{-- Users --}}
                <li class="nav-item">
                    <a href="{{ route('check_in.create') }}"
                        class="nav-link @yield('checkin')">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <p>
                            Checkin
                        </p>
                    </a>
                </li>
                {{-- End Users --}}
                {{-- Checkin --}}
                <li class="nav-item">
                    <a href="{{ route('members.index') }}"
                        class="nav-link @yield('member')">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Member
                        </p>
                    </a>
                </li>
                {{-- End Checkin --}}
                @role('admin')
                {{-- Checkin --}}
                <li class="nav-item">
                    <a href="{{ route('check_in.index') }}"
                        class="nav-link @yield('checkin.index')">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <p>
                            In-Out
                        </p>
                    </a>
                </li>
                {{-- End Checkin --}}
                {{-- Checkin --}}
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link @yield('user')">
                        <i class="fas fa-users nav-icon"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                {{-- End Checkin --}}
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
