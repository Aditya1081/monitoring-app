@extends('master')
@section('content')
    @role('admin')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Form Kelas</h3>
                                <form id="createForm" class="forms-sample" action="{{ route('paralel.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama_kelas">Nama Kelas</label>
                                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                                            id="nama_kelas" name="nama_kelas" placeholder="Masukkan Nama Kelas" required>
                                        @error('nama_kelas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success mr-2" id="tambah">Tambah</button>
                                    <a href="{{ route('paralel.index') }}" class="btn btn-light">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
