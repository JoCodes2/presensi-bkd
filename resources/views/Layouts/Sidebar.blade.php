<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/Logo_BKD.png') }}" alt="Logo" class="img-fluid" width="70"
                        height="70">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{-- @auth
                                {{ auth()->user()->name }}
                            @endauth
                            @auth
                                <span class="user-level">{{ auth()->user()->username }}</span>
                            @endauth --}}

                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('presensi*') ? 'active' : '' }}">
                    <a href="{{ url('/presensi') }}">
                        <i class="fas fa-calendar-check"></i>
                        <p>Presensi Pegawai</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('pegawai*') ? 'active' : '' }}">
                    <a href="{{ url('/pegawai') }}">
                        <i class="fas fa-users"></i>
                        <p>Pegawai</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('jam*') ? 'active' : '' }}">
                    <a href="{{ url('/jam') }}">
                        <i class="fas fa-clock"></i>
                        <p>Jam Kerja</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('kantor*') ? 'active' : '' }}">
                    <a href="{{ url('/kantor') }}">
                        <i class="fas fa-building"></i>
                        <p>Lokasi Kantor</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('jabatan*') ? 'active' : '' }}">
                    <a href="{{ url('/jabatan') }}">
                        <i class="fas fa-user-tie"></i>
                        <p>Jabatan</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
