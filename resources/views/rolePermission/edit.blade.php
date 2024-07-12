@extends('master')

@section('content')
@role('admin')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Edit Hak Akses</b></h3>
                            <form action="{{ route('role_permission.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" id="role" value="{{ $role->name }}"
                                        disabled>
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
                                                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
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
                                    <button type="submit" class="btn btn-warning mr-2">Ubah</button>
                                    <a href="{{ route('role_permission.index') }}" class="btn btn-light">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input, select').on('input change', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });
        });
    </script>
@endrole
@endsection
