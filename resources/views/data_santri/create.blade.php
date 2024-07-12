@extends('master')
@section('content')
    @role('admin')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h3><b>Form Data Santri</b></h3>
                                <form class="form-sample" action="{{ route('data_santri.store') }}" method="POST">
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nama Santri</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_santri"
                                                        name="nama_santri" placeholder="Masukkan Nama Lengkap" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">NIS</label>
                                                <div class="col-sm-9">
                                                    <input type="text" maxlength="16" class="form-control" id="NIS"
                                                        name="NIS" placeholder="Masukkan NIS" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">NISN</label>
                                                <div class="col-sm-9">
                                                    <input type="text" maxlength="16" class="form-control" id="NISN"
                                                        name="NISN" placeholder="Masukkan NISN" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">NIK</label>
                                                <div class="col-sm-9">
                                                    <input type="text" maxlength="16" class="form-control" id="NIK"
                                                        name="NIK" placeholder="Masukkan NIK" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kota Kelahiran</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="kota_lahir" name="kota_lahir"
                                                        placeholder="Masukkan Kota Kelahiran" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Alamat</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                                        placeholder="Masukkan Alamat Lengkap" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" required>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="jenis_kelamin"
                                                                id="jenis_kelamin" value="Laki-laki">
                                                            Laki - laki
                                                            <i class="input-helper"></i></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="jenis_kelamin"
                                                                id="jenis_kelamin" value="Perempuan" required>
                                                            Perempuan
                                                            <i class="input-helper"></i></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nama Wali Santri</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_wali_santri"
                                                        name="nama_wali_santri" placeholder="Masukkan Nama Wali Santri"
                                                        maxlength="12">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Masukkan Password untuk Wali Santri">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">No Telp Wali Santri</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="no_telp_wali"
                                                        name="no_telp_wali"
                                                        placeholder="Masukkan nomor WA / yang bisa dihubungi" maxlength="12">
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Kelas</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="id_kelas" name="id_kelas" required>
                                                        <option value="">Pilih Kelas</option>
                                                        @foreach ($kelasList as $kelas)
                                                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Kamar</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="id_kamar" name="id_kamar" required>
                                                        <option value="">Pilih Kamar</option>
                                                        @foreach ($kamarList as $kamar)
                                                            <option value="{{ $kamar->id_kamar }}">{{ $kamar->nama_kamar }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Kelas Madin</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="id_kelas_madin" name="id_kelas_madin">
                                                        <option value="">Pilih Kelas Madin</option>
                                                        @foreach ($madinList as $madin)
                                                            <option value="{{ $madin->id_kelas_madin }}">
                                                                {{ $madin->nama_kelas_madin }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Kelas TPQ</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="id_jilid" name="id_jilid">
                                                        <option value="">Pilih Kelas TPQ</option>
                                                        @foreach ($jilidList as $jilid)
                                                            <option value="{{ $jilid->id_jilid }}">{{ $jilid->nama_jilid }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">No VA</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="no_va" name="no_va"
                                                        placeholder="Masukkan No VA" maxlength="12">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success mr-2">Tambah</button>
                                    <a href="{{ route('data_santri.index') }}" class="btn btn-light">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endrole
@endsection
