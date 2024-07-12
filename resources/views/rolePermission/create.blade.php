@extends('master')
@section('content')
@role('admin')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Hak Akses</b></h3>
                            <form action="{{ route('role_permission.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <select name="role_id" id="role_id" class="form-control">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Permissions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menus as $menuName => $menuKey)
                                                <tr>
                                                    <td>{{ $menuName }}</td>
                                                    <td>
                                                        <div class="row">
                                                            @php
                                                                $filteredPermissions = $permissions->filter(function (
                                                                    $permission,
                                                                ) use ($menuKey) {
                                                                    return strpos($permission->name, $menuKey) !==
                                                                        false;
                                                                });

                                                                // Remove specific words from menuKey
                                                                $menuKeyWithoutWord = str_replace(
                                                                    [
                                                                        'perizinan',
                                                                        'absensi',
                                                                        'penilaian',
                                                                        'pelanggaran',
                                                                        'prestasi',
                                                                    ],
                                                                    '',
                                                                    $menuKey,
                                                                );
                                                            @endphp

                                                            @foreach ($filteredPermissions as $permission)
                                                                @php
                                                                    // Remove specific words from permission name
                                                                    $label = str_replace(
                                                                        [
                                                                            'perizinan',
                                                                            'absensi',
                                                                            'penilaian',
                                                                            'pelanggaran',
                                                                            'prestasi',
                                                                        ],
                                                                        '',
                                                                        $permission->name,
                                                                    );
                                                                @endphp
                                                                @if ($label !== '')
                                                                    <div class="col-md-2 mb-2">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input type="checkbox" name="permissions[]"
                                                                                    value="{{ $permission->id }}"
                                                                                    id="permission{{ $permission->id }}"
                                                                                    class="form-check-input"
                                                                                    {{ $permission->checked ? 'checked' : '' }}>
                                                                                {{ $label }}
                                                                                <i class="input-helper"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mr-2">Tambah</button>
                                    <a href="{{ route('role_permission.index') }}" class="btn btn-light">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endrole
@endsection
