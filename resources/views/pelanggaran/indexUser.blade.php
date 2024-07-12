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
                                    <h3><b>Data Pelanggaran Santri</b></h3>
                                </div>

                                <form method="GET" action="{{ route('pelanggaran.index') }}" class="mt-3 mb-3">
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
                                                <th>Pelanggaran</th>
                                                <th>Point</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($pelanggarans && count($pelanggarans) > 0)
                                                @foreach ($pelanggarans as $pelanggaran)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $pelanggaran->nama_pelanggaran }}</td>
                                                        <td>{{ $pelanggaran->point }}</td>
                                                        <td>{{ $pelanggaran->deskripsi_pelanggaran }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->locale('id')->translatedFormat('d F Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center" style="color: red">Data pelanggaran
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
