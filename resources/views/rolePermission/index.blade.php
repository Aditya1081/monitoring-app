@extends('master')

@section('content')
    @role('admin')
        <style>
            .btn {
                min-width: 100px;
                /* Sesuaikan kebutuhan jika diperlukan */
            }
        </style>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><b>Role Permissions</b></h3>
                                    <a href="{{ route('role_permission.create') }}" class="btn btn-success">Tambah</a>
                                </div>
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Role</th>
                                                <th style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rolePermissions as $no => $role)
                                                <tr>
                                                    <td>{{ $rolePermissions->firstItem() + $no }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td class="d-flex flex-row align-items-stretch">
                                                        <a href="{{ route('role_permission.show', $role->id) }}"
                                                            class="btn btn-info mr-2 flex-grow-1">Lihat</a>
                                                        <a href="{{ route('role_permission.edit', $role->id) }}"
                                                            class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                        <form action="{{ route('role_permission.destroy', $role->id) }}"
                                                            method="POST" class="flex-grow-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" id="hapus"
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
                                        Menampilkan {{ $rolePermissions->firstItem() }} sampai
                                        {{ $rolePermissions->lastItem() }} dari total {{ $totalItems }} item
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $rolePermissions->links() }}
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
