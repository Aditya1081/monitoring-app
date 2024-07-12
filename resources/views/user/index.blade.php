@extends('master')
@section('content')
    @role('admin')
        <style>
            .btn {
                min-width: 100px;
            }

            .dropdown-container {
                display: flex;
                align-items: center;
                margin-top: 10px;
            }

            .dropdown-container label {
                margin-right: 10px;
                margin-bottom: 0;
            }

            .dropdown-container select {
                width: 80px;
                padding: 5px;
                font-size: 14px;
            }
        </style>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><b>Data User</b></h3>
                                    <a href="{{ route('user.create') }}" class="btn btn-success">Tambah</a>
                                </div>

                                <div class="dropdown-container">
                                    <label for="perPage">Tampilkan</label>
                                    <select id="perPage" class="form-control" onchange="location = this.value;">
                                        <option value="{{ request()->fullUrlWithQuery(['perPage' => 5]) }}"
                                            {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="{{ request()->fullUrlWithQuery(['perPage' => 10]) }}"
                                            {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="{{ request()->fullUrlWithQuery(['perPage' => 15]) }}"
                                            {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                                    </select>
                                    <label for="perPage" class="ml-2">Data</label>
                                </div>

                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Nama User</th>
                                                <th>Username</th>
                                                <th>Roles</th>
                                                <th style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $no => $user)
                                                <tr>
                                                    <td>{{ $users->firstItem() + $no }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>
                                                        @foreach ($user->roles as $role)
                                                            <!-- <span class="badge badge-primary">{{ $role->name }}</span> -->
                                                            {{ $role->name }}
                                                        @endforeach
                                                    </td>
                                                    <td class="d-flex flex-row align-items-stretch">
                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                            class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                            class="flex-grow-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="hapus" type="submit"
                                                                class="btn btn-danger w-100">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 d-flex justify-content-between align-items-center">
                                    <div class="col-md-6">
                                        Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }}
                                        dari
                                        total {{ $totalItems }} item
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $users->appends(['perPage' => $perPage])->links() }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
