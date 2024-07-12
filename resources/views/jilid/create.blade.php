@extends('master')
@section('content')
    @role('admin')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Form Jilid</h3>
                                <form id="createForm" class="forms-sample" action="{{ route('jilid.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama_kelas">Nama Jilid</label>
                                        <input type="text" class="form-control @error('nama_jilid') is-invalid @enderror"
                                            id="nama_jilid" name="nama_jilid" placeholder="Masukkan Nama Jilid" required>
                                        @error('nama_jilid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success mr-2" id="tambah">Tambah</button>
                                    <a href="{{ route('jilid.index') }}" class="btn btn-light">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
