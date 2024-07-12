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
                                    <h3><b>Data Nilai Jilid Santri</b></h3>
                                </div>

                                <form method="GET" action="{{ route('nilai_jilid.index') }}" class="mt-3 mb-3">
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
                                                <th>Nama Jilid</th>
                                                <th>Keterangan Nilai</th>
                                                <th>Halaman</th>
                                                <th>Catatan</th>
                                                <th>Tanggal Penilaian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($nilaiJilid && $nilaiJilid->count() > 0)
                                                @foreach ($nilaiJilid as $nilai)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $nilai->DataSantri->nama_santri }}</td>
                                                        <td>{{ $nilai->jilid->nama_jilid }}</td>
                                                        <td>{{ $nilai->keterangan_nilai }}</td>
                                                        <td>{{ $nilai->halaman }}</td>
                                                        <td>{{ $nilai->catatan ?? '-' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($nilai->tanggal_penilaian)->locale('id')->translatedFormat('d F Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center" style="color: red">Data nilai jilid
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
