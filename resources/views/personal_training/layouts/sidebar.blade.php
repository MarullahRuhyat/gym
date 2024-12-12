<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
<div class="sidebar-header">
    <div class="logo-icon">
        <img src="{{ URL::asset('build/images/logo-icon.png') }}" class="logo-img" alt="">
    </div>
    <div class="logo-name flex-grow-1">
        <h5 class="mb-0">Flozor's Gym</h5>
    </div>
    <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
    </div>
</div>
<div class="sidebar-nav">
    <!--navigation-->
    <ul class="metismenu" id="sidenav">
        <li>
            <a href="{{ route('personal_trainer.dashboard')}}">
                <div class="parent-icon"><i class="material-icons-outlined">home</i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>

        </li>
        <li>
            <a href="{{ route('personal_trainer.payment.index')}}">
                <div class="parent-icon"><i class="material-icons-outlined">payments</i>
                </div>
                <div class="menu-title">Gaji</div>
            </a>

        </li>
        <li>
            <a href="{{ route('personal_trainer.attendance_member')}}">
                <div class="parent-icon"><i class="material-icons-outlined">group</i>
                </div>
                <div class="menu-title">Absen Member</div>
            </a>

        </li>
        <li>
            <a href="{{ route('pt_scan')}}">
                <div class="parent-icon"><i class="material-icons-outlined">qr_code_scanner</i>
                </div>
                <div class="menu-title">Scan</div>
            </a>
        </li>

        <li>
            <a href="{{ route('personal_trainer.profile')}}">
                <div class="parent-icon"><i class="material-icons-outlined">person</i>
                </div>
                <div class="menu-title">Profile</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
</aside>
<!--end sidebar-->