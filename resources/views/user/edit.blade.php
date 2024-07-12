@extends('master')
@section('content')
@role('admin')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3><b>Ubah User</b></h3>
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Pilih Role</label>
                                <div>
                                    <div class="custom-select-wrapper">
                                        <select class="form-control @error('roles') is-invalid @enderror" id="roles" name="roles[]" required>
                                            <option value="">Pilih Role</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="custom-arrow">&gt;</span>
                                    </div>
                                    @error('roles')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password">
                            </div>

                            <button type="submit" class="btn btn-warning mr-2">Ubah</button>
                            <a href="{{ route('user.index') }}" class="btn btn-light">Kembali</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection


<style>
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 100%;
        padding-right: 30px;
        background-color: transparent;
    }

    .custom-arrow {
        position: absolute;
        top: 50%;
        right: 30px;
        transform: translateY(-50%) rotate(0deg);
        transition: transform 0.3s ease;
        pointer-events: none;
        font-size: 16px;
        color: black;
    }

    .custom-select-wrapper select:focus+.custom-arrow {
        transform: translateY(-50%) rotate(90deg);
    }

    .custom-select-wrapper.select.is-invalid select {
        border-color: #dc3545;
    }
</style>