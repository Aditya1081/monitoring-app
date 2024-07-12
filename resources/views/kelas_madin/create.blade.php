@extends('master')
@section('content')
    @role('admin')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Form Kelas Madin</h3>
                                <form id="createForm" class="forms-sample" action="{{ route('kelas_madin.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama_kelas">Nama Kelas Madin</label>
                                        <input type="text"
                                            class="form-control @error('nama_kelas_madin') is-invalid @enderror"
                                            id="nama_kelas_madin" name="nama_kelas_madin" placeholder="Masukkan Nama Kelas"
                                            required>
                                        @error('nama_kelas_madin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success mr-2" id="tambah">Tambah</button>
                                    <a href="{{ route('kelas_madin.index') }}" class="btn btn-light">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
