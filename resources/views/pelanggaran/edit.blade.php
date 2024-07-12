@extends('master')
@section('content')
@can('update pelanggaran')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Form Ubah Pelanggaran</b></h3>
                            <form class="form-sample" action="{{ route('pelanggaran.update', $pelanggaran->id_pelanggaran) }}"
                                method="POST" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label">Kamar</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nama_kamar" name="nama_kamar"
                                                    value="{{ $pelanggaran->kamar->nama_kamar }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label">Nama Santri</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nama_santri"
                                                    name="nama_santri" value="{{ $pelanggaran->DataSantri->nama_santri }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Pelanggaran</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('nama_pelanggaran') is-invalid @enderror"
                                                    id="nama_pelanggaran" name="nama_pelanggaran"
                                                    placeholder="Masukkan Jenis Pelanggaran"
                                                    value="{{ old('nama_pelanggaran', $pelanggaran->nama_pelanggaran) }}"
                                                    required>
                                                @error('nama_pelanggaran')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tanggal</label>
                                            <div class="col-sm-9">
                                                <input type="date"
                                                    class="form-control @error('tanggal_pelanggaran') is-invalid @enderror"
                                                    id="tanggal_pelanggaran" name="tanggal_pelanggaran"
                                                    value="{{ old('tanggal_pelanggaran', $pelanggaran->tanggal_pelanggaran) }}"
                                                    required>
                                                @error('tanggal_pelanggaran')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label">Point Pelanggaran</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('point') is-invalid @enderror" id="point"
                                                    name="point" placeholder="Masukkan Point Pelanggaran"
                                                    value="{{ old('point', $pelanggaran->point) }}" required>
                                                @error('point')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label">Deskripsi</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('deskripsi_pelanggaran') is-invalid @enderror"
                                                    id="deskripsi_pelanggaran" name="deskripsi_pelanggaran"
                                                    placeholder="Masukkan Deskripsi Pelanggaran"
                                                    value="{{ old('deskripsi_pelanggaran', $pelanggaran->deskripsi_pelanggaran) }}">
                                                <small class="form-text text-muted">Isi kolom deskripsi dengan informasi
                                                    tambahan jika diperlukan.</small>
                                                @error('deskripsi_pelanggaran')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning mr-2">Ubah</button>
                                <a href="{{ route('pelanggaran.index') }}" class="btn btn-light">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
@endsection
