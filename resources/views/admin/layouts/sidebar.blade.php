<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ URL::asset('build/images/logo-icon.png') }}" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">Maxton</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="{{ route('admin_dashboard')}}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>

            </li>
            <li>
                <a href="{{ route('admin_scan')}}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Scan</div>
                </a>

            </li>
            <li>
                <a href="{{ route('admin_absen')}}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Attendance</div>
                </a>

            </li>
            <li>
                <a href="{{ route('admin_gaji')}}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Salary</div>
                </a>

            </li>
            <li>
                <a href="{{ route('admin_member')}}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Member</div>
                </a>

            </li>
            <li>
                <a href="{{ route('admin_personal_trainer')}}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Personal Trainer</div>
                </a>

            </li>
            <li class="menu-label">Master</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="material-icons-outlined">shopping_bag</i>
                    </div>
                    <div class="menu-title">Master</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin_jenis_latihan')}}"><i class="material-icons-outlined">arrow_right</i>Jenis Latihan</a>
                    </li>
                    <li>
                        <a href="{{ route('admin_membership_package')}}"><i class="material-icons-outlined">arrow_right</i>Membership Packages</a>
                    </li>
                </ul>
            </li>

        </ul>
        <!--end navigation-->
    </div>
</aside>
<!--end sidebar-->