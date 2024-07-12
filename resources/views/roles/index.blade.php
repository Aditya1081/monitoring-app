@extends('master')
@section('content')
@role('admin')
    <style>
        .btn {
            min-width: 100px;
            /* Anda bisa menyesuaikan ini jika diperlukan */
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Data Roles</b></h3>
                                <a href="{{ route('roles.create') }}" class="btn btn-success">Tambah</a>
                            </div>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Roles</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $no => $role)
                                            <tr>
                                                <td>{{ $roles->firstItem() + $no }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td class="d-flex flex-row align-items-stretch">
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                    <form action="{{ route('roles.destroy', $role->id) }}"
                                                        method="POST" class="flex-grow-1">
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

                            <div class="mt-4 d-flex justify-content-between">
                                <div>
                                    Menampilkan {{ $roles->firstItem() }} sampai {{ $roles->lastItem() }} dari total
                                    {{ $totalItems }} item
                                </div>
                                <div>
                                    {{ $roles->links() }}
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
