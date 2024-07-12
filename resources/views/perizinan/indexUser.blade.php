@extends('master')
@section('content')
    @can('index perizinan')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><b>Data Izin Santri</b></h3>
                                    @can('create perizinan')
                                        <a href="{{ route('perizinan.create') }}" class="btn btn-success">Pengajuan</a>
                                    @endcan
                                </div>

                                <form method="GET" action="{{ route('perizinan.index') }}" class="mt-3 mb-3">
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

                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Santri</th>
                                                <th>Perihan Izin</th>
                                                <th>Deskripsi Perizinan</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Akhir</th>
                                                <th>Status Perizinan</th>
                                                <th>Deskripsi Penolakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($dataPerizinan && count($dataPerizinan) > 0)
                                                @foreach ($dataPerizinan as $perizinan)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $perizinan->DataSantri->nama_santri }}</td>
                                                        <td>{{ $perizinan->nama_perizinan }}</td>
                                                        <td>{{ $perizinan->deskripsi_perizinan }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($perizinan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                        </td>
                                                        <td>
                                                            @if ($perizinan->tanggal_akhir)
                                                                {{ \Carbon\Carbon::parse($perizinan->tanggal_akhir)->locale('id')->translatedFormat('d F Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge custom-badge
                                                                @if ($perizinan->status_perizinan == 'Menunggu Konfirmasi') badge-warning
                                                                @elseif ($perizinan->status_perizinan == 'Ditolak') badge-danger
                                                                @elseif ($perizinan->status_perizinan == 'Disetujui') badge-success
                                                                @elseif ($perizinan->status_perizinan == 'Tepat Waktu') badge-success
                                                                @elseif ($perizinan->status_perizinan == 'Datang Terlambat') badge-danger @endif"
                                                                style="font-size: 12px;
                                                                    padding: 6px 10px;
                                                                    border-radius: 8px;
                                                                    color: #fff;
                                                                    display: inline-block;
                                                                    max-width: 100px;
                                                                    text-align: center;
                                                                    overflow: hidden;
                                                                    white-space: normal;">
                                                                {{ $perizinan->status_perizinan }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $perizinan->deskripsi_pengurus }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center" style="color: red">Data perizinan
                                                        tidak ditemukan.
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
    @endcan
@endsection
