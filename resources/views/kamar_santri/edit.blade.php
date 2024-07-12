@extends('master')
@section('content')
@role('admin')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Form Edit Data Kamar</h3>
                            <form class="forms-sample" method="POST"
                                action="{{ route('kamar_santri.update', $kamarsantri->id_kamar) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nama_kamar">Nama Kamar</label>
                                    <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror"
                                        id="nama_kamar" name="nama_kamar" placeholder="Kamar 1"
                                        value="{{ $kamarsantri->nama_kamar }}">
                                    @error('nama_kamar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-warning mr-2">Ubah</button>
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
