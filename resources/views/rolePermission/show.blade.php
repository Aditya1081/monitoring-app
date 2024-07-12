@extends('master')

@section('content')
@role('admin')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Permissions : {{ $role->name }}</b></h3>
                            @csrf
                            @method('PUT')
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fitur</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menuName => $menuKey)
                                        <tr>
                                            <td>{{ $menuName }}</td>
                                            <td>
                                                <div class="row">
                                                    @foreach ($permissionsByMenu[$menuName] as $permission)
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
                                                        <div class="col-md-2 mb-2">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission{{ $permission->id }}"
                                                                        class="form-check-input"
                                                                        {{ $permission->checked ? 'checked' : '' }}
                                                                        disabled>
                                                                    {{ $label }}
                                                                    <i class="input-helper"></i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a href="{{ route('role_permission.index') }}" class="btn btn-light">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endrole
@endsection
