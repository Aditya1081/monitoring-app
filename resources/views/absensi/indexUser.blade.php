@extends('master')

@section('content')
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Data Absensi Santri</b></h3>
                            </div>

                            <form method="GET" action="{{ route('absensi.index') }}" class="mt-3 mb-3">
                                <p>Pilih Data Sesuai :</p>
                                <div class="row align-items-center">
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                        <select name="month" class="form-control">
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                        <select name="year" class="form-control">
                                            @for ($y = 2021; $y <= \Carbon\Carbon::now()->year; $y++)
                                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mt-3 mt-sm-0">
                                        <button type="submit" class="btn btn-info">Tampilkan</button>
                                    </div>
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
                                                    <th>Tanggal Absensi</th>
                                                    <th>Jenis Absensi</th>
                                                    <th>Status Absensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($absensiPagi && count($absensiPagi) > 0)
                                                    @foreach ($absensiPagi as $no => $absensi)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($absensi->tanggal_absensi)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>{{ $absensi->jenis_absensi }}</td>
                                                            <td>{{ $absensi->status_absensi }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center" style="color: red">Data
                                                            absensi tidak ditemukan.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sore" role="tabpanel" aria-labelledby="sore-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Absensi</th>
                                                    <th>Jenis Absensi</th>
                                                    <th>Status Absensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($absensiSore && count($absensiSore) > 0)
                                                    @foreach ($absensiSore as $no => $absensi)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($absensi->tanggal_absensi)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>{{ $absensi->jenis_absensi }}</td>
                                                            <td>{{ $absensi->status_absensi }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center" style="color: red">Data
                                                            absensi tidak ditemukan.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
