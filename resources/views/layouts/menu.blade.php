<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo w-75">
                <span style="">
                    <img src="{{asset('assets/img/logoSIM.png')}}" class="w-100" alt="logo" srcset="">
                </span>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                    fill="currentColor" fill-opacity="0.6"/>
                <path
                    d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z"
                    fill="currentColor" fill-opacity="0.38"/>
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item @if (Request::is('/')) active @endif ">
            <a href="{{ url('/') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-view-dashboard-variant"></i>
                <div>Dashboard</div>
            </a>
        </li>
        @if(in_array(Auth::User()->role, ['Admin', 'Petugas']))
        <li class="menu-item  @if(in_array(Request::getRequestUri(),['/patients', '/visits'])) active open @endif ">
            <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                <i class="menu-icon tf-icons mdi mdi-clipboard-account"></i>
                <div>Pendaftaran</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Request::is('patients')) active @endif">
                    <a href="{{ route('patients.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-account-group"></i>
                        <div>Pasien</div>
                    </a>
                </li>
                <li class="menu-item @if (Request::is('visits')) active @endif">
                    <a href="{{ route('visits.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-calendar-check"></i>
                        <div>Kunjungan</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(in_array(Auth::User()->role, ['Admin', 'Dokter']))
        <li class="menu-item  @if(in_array(Request::getRequestUri(),['/visit-treatment', '/visit-prescription'])) active open @endif ">
            <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                <i class="menu-icon tf-icons mdi mdi-medical-bag"></i>
                <div>Tindakan dan Obat</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Request::is('visit-treatment')) active @endif">
                    <a href="{{ route('visitTreatment.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-stethoscope"></i>
                        <div>Tindakan</div>
                    </a>
                </li>
                <li class="menu-item @if (Request::is('visit-prescription')) active @endif">
                    <a href="{{ route('visitPrescription.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-prescription"></i>
                        <div>Resep</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(in_array(Auth::User()->role, ['Admin', 'Kasir']))
        <li class="menu-item @if (Request::is('visit-bill')) active @endif">
            <a href="{{ route('visitBill.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-cash-register"></i>
                <div>Pembayaran</div>
            </a>
        </li>
        @endif

        @if(in_array(Auth::User()->role, ['Admin']))
        <li class="menu-item  @if(in_array(Request::getRequestUri(),['/regions', '/employees', '/treatments', '/medicines', '/manage-user'])) active open @endif ">
            <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                <i class="menu-icon tf-icons mdi mdi-database"></i>
                <div>Master Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Request::is('regions')) active @endif">
                    <a href="{{ route('regions.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-map-marker-radius"></i>
                        <div>Wilayah</div>
                    </a>
                </li>

                <li class="menu-item @if (Request::is('employees')) active @endif">
                    <a href="{{ route('employees.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-account-tie"></i>
                        <div>Karyawan</div>
                    </a>
                </li>

                <li class="menu-item @if (Request::is('treatments')) active @endif">
                    <a href="{{ route('treatments.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-stethoscope"></i>
                        <div>Tindakan</div>
                    </a>
                </li>

                <li class="menu-item @if (Request::is('medicines')) active @endif">
                    <a href="{{ route('medicines.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-pill"></i>
                        <div>Obat</div>
                    </a>
                </li>

                <li class="menu-item @if (Request::is('manage-user')) active @endif ">
                    <a href="{{ route('user.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-account-cog"></i>
                        <div>User</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
</aside>
