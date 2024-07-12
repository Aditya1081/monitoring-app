<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @role('admin')
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="icon-box menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#manajemen_data"
                    aria-expanded="{{ request()->is('manajemen_data/kamar_santri*') || request()->is('manajemen_data/paralel*') || request()->is('manajemen_data/data_santri*') || request()->is('manajemen_data/jilid*') || request()->is('manajemen_data/kelas_madin*') ? 'true' : 'false' }}"
                    aria-controls="manajemen_data">
                    <i class="icon-file menu-icon"></i>
                    <span class="menu-title">Manajemen Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ request()->is('manajemen_data/kamar_santri*') || request()->is('manajemen_data/paralel*') || request()->is('manajemen_data/data_santri*') || request()->is('manajemen_data/jilid*') || request()->is('manajemen_data/kelas_madin*') ? 'show' : '' }}"
                    id="manajemen_data">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_data/kamar_santri*') ? 'active' : '' }}"
                                href="{{ route('kamar_santri.index') }}">Data Kamar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_data/paralel*') ? 'active' : '' }}"
                                href="{{ route('paralel.index') }}">Data Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_data/kelas_madin*') ? 'active' : '' }}"
                                href="{{ route('kelas_madin.index') }}">Data Kelas Madin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_data/jilid*') ? 'active' : '' }}"
                                href="{{ route('jilid.index') }}">Data Jilid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_data/data_santri*') ? 'active' : '' }}"
                                href="{{ route('data_santri.index') }}">Data Santri</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">

                <a class="nav-link" data-toggle="collapse" href="#manajemen_user"
                    aria-expanded="{{ request()->is('manajemen_user/user*') || request()->is('manajemen_user/roles*') || request()->is('manajemen_user/permissions*') || request()->is('manajemen_user/role_permission*') ? 'true' : 'false' }}"
                    aria-controls="manajemen_user">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Manajemen User</span>
                    <i class="menu-arrow"></i>
                </a>

                <div class="collapse {{ request()->is('manajemen_user/user*') || request()->is('manajemen_user/roles*') || request()->is('manajemen_user/permissions*') || request()->is('manajemen_user/role_permission*') ? 'show' : '' }}"
                    id="manajemen_user">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_user/user*') ? 'active' : '' }}"
                                href="{{ route('user.index') }}">User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_user/roles*') ? 'active' : '' }}"
                                href="{{ route('roles.index') }}">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_user/permissions*') ? 'active' : '' }}"
                                href="{{ route('permissions.index') }}">Permissions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manajemen_user/role_permission*') ? 'active' : '' }}"
                                href="{{ route('role_permission.index') }}">Role Permission</a>
                        </li>
                    </ul>
                </div>
            </li>


            @can('index perizinan')
                <li class="nav-item {{ request()->is('perizinan*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" href="{{ route('perizinan.index') }}">
                        <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="white"
                            viewBox="0 0 48 48">
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="M40.12 15.71 29.29 4.88A3 3 0 0 0 27.17 4H10a3 3 0 0 0-3 3v5a1 1 0 0 0 2 0V7a1 1 0 0 1 1-1h17v9a3 3 0 0 0 3 3h9v23a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V16a1 1 0 0 0-2 0v25a3 3 0 0 0 3 3h28a3 3 0 0 0 3-3V17.83a3 3 0 0 0-.88-2.12ZM29 15V7.41L37.59 16H30a1 1 0 0 1-1-1Zm-5 6a8 8 0 1 0 8 8 8 8 0 0 0-8-8Zm0 14a6 6 0 1 1 6-6 6 6 0 0 1-6 6Zm3.71-3.71a1 1 0 0 1 0 1.42 1 1 0 0 1-1.42 0l-3-3A1 1 0 0 1 23 29v-4a1 1 0 0 1 2 0v3.59Z"
                                stroke="white" stroke-width="1" />
                        </svg>
                        <span class="menu-title ms-2" style="margin-left: 15px;">Perizinan</span>
                    </a>
                </li>
            @endcan


            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-center" data-toggle="collapse"
                    href="#penilaian"
                    aria-expanded="{{ request()->is('penilaian/mapel_madin*') || request()->is('penilaian/nilai_jilid*') ? 'true' : 'false' }}"
                    aria-controls="penilaian">
                    <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="white"
                        viewBox="0 0 48 48">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M40.12 15.71 29.29 4.88A3 3 0 0 0 27.17 4H10a3 3 0 0 0-3 3v5a1 1 0 0 0 2 0V7a1 1 0 0 1 1-1h17v9a3 3 0 0 0 3 3h9v23a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V16a1 1 0 0 0-2 0v25a3 3 0 0 0 3 3h28a3 3 0 0 0 3-3V17.83a3 3 0 0 0-.88-2.12ZM29 15V7.41L37.59 16H30a1 1 0 0 1-1-1Zm-15 8a1 1 0 0 1 1-1h9a1 1 0 0 1 0 2h-9a1 1 0 0 1-1-1Zm1 5h18a1 1 0 0 1 0 2H15a1 1 0 0 1 0-2Zm19 7a1 1 0 0 1-1 1H15a1 1 0 0 1 0-2h18a1 1 0 0 1 1 1Z"
                            stroke="white" stroke-width="1" />
                    </svg>
                    <span class="menu-title ms-2" style="margin-left: 15px;">Penilaian</span>
                    <i class="menu-arrow"></i>
                </a>

                <div class="collapse {{ request()->is('penilaian/mapel_madin*') || request()->is('penilaian/nilai_jilid*') ? 'show' : '' }}"
                    id="penilaian">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('penilaian/mapel_madin*') ? 'active' : '' }}"
                                href="{{ route('mapel_madin.index') }}">Mapel Madin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('penilaian/nilai_jilid*') ? 'active' : '' }}"
                                href="{{ route('nilai_jilid.index') }}">Nilai Jilid</a>
                        </li>
                    </ul>
                </div>
            </li>

            @can('index absensi')
                <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" href="{{ route('absensi.index') }}">
                        <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                            fill="white" viewBox="0 0 48 48">
                            <path
                                d="M40.12,15.71,29.29,4.88A3,3,0,0,0,27.17,4H10A3,3,0,0,0,7,7v5a1,1,0,0,0,2,0V7a1,1,0,0,1,1-1H27v9a3,3,0,0,0,3,3h9V41a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0V41a3,3,0,0,0,3,3H38a3,3,0,0,0,3-3V17.83A3,3,0,0,0,40.12,15.71ZM29,15V7.41L37.59,16H30A1,1,0,0,1,29,15ZM20.34,31.41a1,1,0,0,0-.27.51l-.71,3.54a1,1,0,0,0,1,1.2l.2,0,3.54-.71a1,1,0,0,0,.51-.27l9.19-9.2a1,1,0,0,0,0-1.41L31,22.22a1,1,0,0,0-1.41,0ZM23.39,34l-1.77.35L22,32.61l5.44-5.44h0l1.42,1.42h0Zm8.27-8.27-1.42,1.41h0l-1.41-1.41h0l1.41-1.42ZM14,23a1,1,0,0,1,1-1h9a1,1,0,0,1,0,2H15A1,1,0,0,1,14,23Zm0,4a1,1,0,0,1,1-1h5a1,1,0,0,1,0,2H15A1,1,0,0,1,14,27Zm4,4a1,1,0,0,1-1,1H15a1,1,0,0,1,0-2h2A1,1,0,0,1,18,31Z"
                                stroke="white" stroke-width="1" />
                        </svg>
                        <span class="menu-title ms-2" style="margin-left: 15px;">Absensi</span>
                    </a>
                </li>
            @endcan

            @can('index prestasi')
                <li class="nav-item {{ request()->is('prestasi*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" href="{{ route('prestasi.index') }}">
                        <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                            fill="white" viewBox="0 0 48 48">
                            <path
                                d="M28 28a5 5 0 0 0 1-3 5 5 0 0 0-10 0 5 5 0 0 0 1 3l-2 7.76a1 1 0 0 0 .39 1.06 1 1 0 0 0 1.13 0l2.32-1.54 1.42 1.42a1 1 0 0 0 1.42 0l1.42-1.42 2.32 1.54A1 1 0 0 0 29 37a1 1 0 0 0 .58-.18 1 1 0 0 0 .42-1.06Zm-4-6a3 3 0 1 1-3 3 3 3 0 0 1 3-3Zm2.55 11.17a1 1 0 0 0-1.26.12L24 34.59l-1.29-1.3a1 1 0 0 0-1.26-.12l-.85.56 1.08-4.33a4.79 4.79 0 0 0 4.64 0l1.08 4.33Zm13.57-17.46L29.29 4.88A3 3 0 0 0 27.17 4H10a3 3 0 0 0-3 3v5a1 1 0 0 0 2 0V7a1 1 0 0 1 1-1h17v9a3 3 0 0 0 3 3h9v23a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V16a1 1 0 0 0-2 0v25a3 3 0 0 0 3 3h28a3 3 0 0 0 3-3V17.83a3 3 0 0 0-.88-2.12ZM29 15V7.41L37.59 16H30a1 1 0 0 1-1-1Z"
                                stroke="white" stroke-width="1" />
                        </svg>
                        <span class="menu-title ms-2" style="margin-left: 15px;">Prestasi</span>
                    </a>
                </li>
            @endcan

            @can('index pelanggaran')
                <li class="nav-item {{ request()->is('pelanggaran*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" href="{{ route('pelanggaran.index') }}">
                        <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                            fill="white" viewBox="0 0 48 48">
                            <path
                                d="M40.12,15.71,29.29,4.88A3,3,0,0,0,27.17,4H10A3,3,0,0,0,7,7v5a1,1,0,0,0,2,0V7a1,1,0,0,1,1-1H27v9a3,3,0,0,0,3,3h9V41a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0V41a3,3,0,0,0,3,3H38a3,3,0,0,0,3-3V17.83A3,3,0,0,0,40.12,15.71ZM29,15V7.41L37.59,16H30A1,1,0,0,1,29,15Zm-6,7h2v9H23Zm0,11h2v3H23Z"
                                stroke="white" stroke-width="1" />
                        </svg>
                        <span class="menu-title ms-2" style="margin-left: 15px;">Pelanggaran</span>
                    </a>
                </li>
            @endcan
        @endrole

        @role('user')
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="icon-box menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('perizinan*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('perizinan.index') }}">
                    <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                        fill="white" viewBox="0 0 48 48">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M40.12 15.71 29.29 4.88A3 3 0 0 0 27.17 4H10a3 3 0 0 0-3 3v5a1 1 0 0 0 2 0V7a1 1 0 0 1 1-1h17v9a3 3 0 0 0 3 3h9v23a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V16a1 1 0 0 0-2 0v25a3 3 0 0 0 3 3h28a3 3 0 0 0 3-3V17.83a3 3 0 0 0-.88-2.12ZM29 15V7.41L37.59 16H30a1 1 0 0 1-1-1Zm-5 6a8 8 0 1 0 8 8 8 8 0 0 0-8-8Zm0 14a6 6 0 1 1 6-6 6 6 0 0 1-6 6Zm3.71-3.71a1 1 0 0 1 0 1.42 1 1 0 0 1-1.42 0l-3-3A1 1 0 0 1 23 29v-4a1 1 0 0 1 2 0v3.59Z"
                            stroke="white" stroke-width="1" />
                    </svg>
                    <span class="menu-title ms-2" style="margin-left: 15px;">Perizinan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-center" data-toggle="collapse"
                    href="#penilaian"
                    aria-expanded="{{ request()->is('penilaian/mapel_madin*') || request()->is('penilaian/nilai_jilid*') ? 'true' : 'false' }}"
                    aria-controls="penilaian">
                    <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                        fill="white" viewBox="0 0 48 48">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M40.12 15.71 29.29 4.88A3 3 0 0 0 27.17 4H10a3 3 0 0 0-3 3v5a1 1 0 0 0 2 0V7a1 1 0 0 1 1-1h17v9a3 3 0 0 0 3 3h9v23a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V16a1 1 0 0 0-2 0v25a3 3 0 0 0 3 3h28a3 3 0 0 0 3-3V17.83a3 3 0 0 0-.88-2.12ZM29 15V7.41L37.59 16H30a1 1 0 0 1-1-1Zm-15 8a1 1 0 0 1 1-1h9a1 1 0 0 1 0 2h-9a1 1 0 0 1-1-1Zm1 5h18a1 1 0 0 1 0 2H15a1 1 0 0 1 0-2Zm19 7a1 1 0 0 1-1 1H15a1 1 0 0 1 0-2h18a1 1 0 0 1 1 1Z"
                            stroke="white" stroke-width="1" />
                    </svg>
                    <span class="menu-title ms-2" style="margin-left: 15px;">Penilaian</span>
                    <i class="menu-arrow"></i>
                </a>

                <div class="collapse {{ request()->is('penilaian/mapel_madin*') || request()->is('penilaian/nilai_jilid*') ? 'show' : '' }}"
                    id="penilaian">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('penilaian/nilai_jilid*') ? 'active' : '' }}"
                                href="{{ route('nilai_jilid.index') }}">Nilai Jilid</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('absensi.index') }}">
                    <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                        fill="white" viewBox="0 0 48 48">
                        <path
                            d="M40.12,15.71,29.29,4.88A3,3,0,0,0,27.17,4H10A3,3,0,0,0,7,7v5a1,1,0,0,0,2,0V7a1,1,0,0,1,1-1H27v9a3,3,0,0,0,3,3h9V41a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0V41a3,3,0,0,0,3,3H38a3,3,0,0,0,3-3V17.83A3,3,0,0,0,40.12,15.71ZM29,15V7.41L37.59,16H30A1,1,0,0,1,29,15ZM20.34,31.41a1,1,0,0,0-.27.51l-.71,3.54a1,1,0,0,0,1,1.2l.2,0,3.54-.71a1,1,0,0,0,.51-.27l9.19-9.2a1,1,0,0,0,0-1.41L31,22.22a1,1,0,0,0-1.41,0ZM23.39,34l-1.77.35L22,32.61l5.44-5.44h0l1.42,1.42h0Zm8.27-8.27-1.42,1.41h0l-1.41-1.41h0l1.41-1.42ZM14,23a1,1,0,0,1,1-1h9a1,1,0,0,1,0,2H15A1,1,0,0,1,14,23Zm0,4a1,1,0,0,1,1-1h5a1,1,0,0,1,0,2H15A1,1,0,0,1,14,27Zm4,4a1,1,0,0,1-1,1H15a1,1,0,0,1,0-2h2A1,1,0,0,1,18,31Z"
                            stroke="white" stroke-width="1" />
                    </svg>
                    <span class="menu-title ms-2" style="margin-left: 15px;">Absensi</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('prestasi*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('prestasi.index') }}">
                    <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                        fill="white" viewBox="0 0 48 48">
                        <path
                            d="M28 28a5 5 0 0 0 1-3 5 5 0 0 0-10 0 5 5 0 0 0 1 3l-2 7.76a1 1 0 0 0 .39 1.06 1 1 0 0 0 1.13 0l2.32-1.54 1.42 1.42a1 1 0 0 0 1.42 0l1.42-1.42 2.32 1.54A1 1 0 0 0 29 37a1 1 0 0 0 .58-.18 1 1 0 0 0 .42-1.06Zm-4-6a3 3 0 1 1-3 3 3 3 0 0 1 3-3Zm2.55 11.17a1 1 0 0 0-1.26.12L24 34.59l-1.29-1.3a1 1 0 0 0-1.26-.12l-.85.56 1.08-4.33a4.79 4.79 0 0 0 4.64 0l1.08 4.33Zm13.57-17.46L29.29 4.88A3 3 0 0 0 27.17 4H10a3 3 0 0 0-3 3v5a1 1 0 0 0 2 0V7a1 1 0 0 1 1-1h17v9a3 3 0 0 0 3 3h9v23a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V16a1 1 0 0 0-2 0v25a3 3 0 0 0 3 3h28a3 3 0 0 0 3-3V17.83a3 3 0 0 0-.88-2.12ZM29 15V7.41L37.59 16H30a1 1 0 0 1-1-1Z"
                            stroke="white" stroke-width="1" />
                    </svg>
                    <span class="menu-title ms-2" style="margin-left: 15px;">Prestasi</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('pelanggaran*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('pelanggaran.index') }}">
                    <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                        fill="white" viewBox="0 0 48 48">
                        <path
                            d="M40.12,15.71,29.29,4.88A3,3,0,0,0,27.17,4H10A3,3,0,0,0,7,7v5a1,1,0,0,0,2,0V7a1,1,0,0,1,1-1H27v9a3,3,0,0,0,3,3h9V41a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0V41a3,3,0,0,0,3,3H38a3,3,0,0,0,3-3V17.83A3,3,0,0,0,40.12,15.71ZM29,15V7.41L37.59,16H30A1,1,0,0,1,29,15Zm-6,7h2v9H23Zm0,11h2v3H23Z"
                            stroke="white" stroke-width="1" />
                    </svg>
                    <span class="menu-title ms-2" style="margin-left: 15px;">Pelanggaran</span>
                </a>
            </li>
        @endrole

    </ul>
</nav>
