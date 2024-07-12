@extends('master')
@section('content')

@can('update perizinan')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Form Edit Data Perizinan Santri</b></h3>
                            <form class="forms-sample" method="POST"
                                action="{{ route('perizinan.update', $perizinan->id_perizinan) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="id_kamar">Nama Kama</label>
                                    <input type="text" class="form-control @error('id_kamar') is-invalid @enderror"
                                        id="id_kamar" name="id_kamar" value="{{ $perizinan->kamar->nama_kamar }}">
                                    @error('id_kamar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="id_santri">Nama Santri</label>
                                    <input type="text" class="form-control @error('id_santri') is-invalid @enderror"
                                        id="id_santri" name="id_santri" value="{{ $perizinan->DataSantri->nama_santri }}">
                                    @error('id_santri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_perizinan">Nama Perizinan</label>
                                    <input type="text" class="form-control @error('nama_perizinan') is-invalid @enderror"
                                        id="nama_perizinan" name="nama_perizinan" placeholder="Isi Nama Perizinan"
                                        value="{{ $perizinan->nama_perizinan }}">
                                    @error('nama_perizinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        id="tanggal_mulai" name="tanggal_mulai" value="{{ $perizinan->tanggal_mulai }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                        id="tanggal_akhir" name="tanggal_akhir" value="{{ $perizinan->tanggal_akhir }}">
                                    @error('tanggal_akhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi_perizinan">Deskripsi Perizinan</label>
                                    <textarea class="form-control @error('deskripsi_perizinan') is-invalid @enderror" id="deskripsi_perizinan"
                                        name="deskripsi_perizinan" rows="4" placeholder="Isi Deskripsi Perizinan">{{ $perizinan->deskripsi_perizinan }}</textarea>
                                    @error('deskripsi_perizinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi_perizinan">Keterangan</label>
                                    <textarea class="form-control @error('deskripsi_pengurus') is-invalid @enderror" id="deskripsi_pengurus"
                                        name="deskripsi_pengurus" rows="4" placeholder="Isi Deskripsi Perizinan">{{ $perizinan->deskripsi_pengurus }}</textarea>
                                    @error('deskripsi_pengurus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi_perizinan">Status</label>
                                    <textarea class="form-control @error('status_perizinan') is-invalid @enderror" id="status_perizinan"
                                        name="status_perizinan" rows="4" placeholder="Isi Deskripsi Perizinan">{{ $perizinan->status_perizinan }}</textarea>
                                    @error('status_perizinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-warning mr-2">Ubah</button>
                                <a href="{{ route('perizinan.index') }}" class="btn btn-light">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endcan

@endsection
