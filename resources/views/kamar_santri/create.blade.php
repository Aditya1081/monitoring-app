@extends('master')
@section('content')
    @role('admin')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3><b>Form Data Kamar</b></h3>
                                <form class="forms-sample" action="{{ route('kamar_santri.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama_kamar">Nama Kamar</label>
                                        <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror"
                                            id="nama_kamar" name="nama_kamar" placeholder="Isi Nama Kamar" required>
                                        @error('nama_kamar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success mr-2">Tambah</button>
                                    <a href="{{ route('kamar_santri.index') }}" class="btn btn-light">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
