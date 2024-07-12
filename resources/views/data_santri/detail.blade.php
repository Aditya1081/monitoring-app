@extends('master')
@section('content')
@role('admin')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Detail Data Santri</b></h3>
                                <a href="{{ route('data_santri.index') }}" class="btn btn-light">Kembali</a>
                            </div>
                            <form class="form-sample">
                                <p class="card-description">Informasi Pribadi</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Santri</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $santri->nama_santri }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">NIS</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $santri->NIS }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">NISN</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $santri->NISN }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">NIK</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $santri->NIK }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kota Lahir</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $santri->kota_lahir }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No VA</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="8241002201150001"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $santri->jenis_kelamin }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $santri->alamat }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon Wali</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $santri->no_telp_wali }}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kelas</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $santri->kelasSantri->nama_kelas }}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kamar</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $santri->kamarSantri->nama_kamar }}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kelas Madin</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $santri->madinSantri->nama_kelas_madin ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kelas TPQ</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $santri->jilidSantri->nama_jilid ?? '-'}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endrole
@endsection
