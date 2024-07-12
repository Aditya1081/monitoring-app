@extends('master')

@section('content')

    @can('index absensi')
        <style>
            .btn {
                min-width: 100px;
                /* Anda bisa menyesuaikan ini jika diperlukan */
            }
        </style>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @can('create absensi')
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3><b>Data Absensi</b></h3>
                                        <a href="{{ route('absensi.create') }}" class="btn btn-success">Tambah</a>
                                    </div>
                                @endcan

                                <form action="{{ route('absensi.index') }}" method="GET" class="form-inline">
                                    <div class="form-group">
                                        <label for="tanggal" class="mr-2">Pilih Tanggal:</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            value="{{ $tanggal ?? date('d-m-Y') }}" onchange="this.form.submit()">
                                    </div>
                                </form>


                                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pagi-tab" data-toggle="tab" href="#pagi"
                                            role="tab" aria-controls="pagi" aria-selected="true">Absensi Pagi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sore-tab" data-toggle="tab" href="#sore" role="tab"
                                            aria-controls="sore" aria-selected="false">Absensi Sore</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="pagi" role="tabpanel"
                                        aria-labelledby="pagi-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kamar</th>
                                                        <th>Jumlah Hadir</th>
                                                        <th>Jumlah Tidak Hadir</th>
                                                        <th>Jumlah Sakit</th>
                                                        <th>Jumlah Izin</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($absensiPagi as $no => $absensi)
                                                        <tr>
                                                            <td>{{ $absensiPagi->firstItem() + $no }}</td>
                                                            <td>{{ $absensi->nama_kamar }}</td>
                                                            <td>{{ $absensi->jumlah_hadir_pagi }}</td>
                                                            <td>{{ $absensi->jumlah_tidak_hadir_pagi }}</td>
                                                            <td>{{ $absensi->jumlah_sakit_pagi }}</td>
                                                            <td>{{ $absensi->jumlah_izin_pagi }}</td>
                                                            <td>
                                                                <a href="{{ route('absensi.riwayat', ['id_kamar' => $absensi->id_kamar, 'jenis_absensi' => 'pagi', 'tanggal' => $tanggal]) }}"
                                                                    class="btn btn-info mb-2 mb-md-0 mr-md-2">Data Absensi</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="mt-4 d-flex justify-content-between">
                                                <div>
                                                    {{ $absensiPagi->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sore" role="tabpanel" aria-labelledby="sore-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kamar</th>
                                                        <th>Jumlah Hadir</th>
                                                        <th>Jumlah Tidak Hadir</th>
                                                        <th>Jumlah Sakit</th>
                                                        <th>Jumlah Izin</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($absensiSore as $no => $absensi)
                                                        <tr>
                                                            <td>{{ $absensiSore->firstItem() + $no }}</td>
                                                            <td>{{ $absensi->nama_kamar }}</td>
                                                            <td>{{ $absensi->jumlah_hadir_sore }}</td>
                                                            <td>{{ $absensi->jumlah_tidak_hadir_sore }}</td>
                                                            <td>{{ $absensi->jumlah_sakit_sore }}</td>
                                                            <td>{{ $absensi->jumlah_izin_sore }}</td>
                                                            <td>
                                                                <a href="{{ route('absensi.riwayat', ['id_kamar' => $absensi->id_kamar, 'jenis_absensi' => 'sore', 'tanggal' => $tanggal]) }}"
                                                                    class="btn btn-info mb-2 mb-md-0 mr-md-2">Data Absensi</a>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="mt-4 d-flex justify-content-between">
                                                <div>
                                                    {{ $absensiSore->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection
