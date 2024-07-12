@extends('master')

@section('content')

    @can('index absensi')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('nilai_jilid.updateNilaiJilid', ['id_jilid' => $jilid->id_jilid]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="table-responsive pt-3">
                                        <div class="table-header text-center p-3">
                                            <h3><b>DATA PENILAIAN JILID</b></h3>
                                        </div>
                                    </div>

                                    <table class="my-3">
                                        <tbody>
                                            <tr class="spacing-row">
                                                <td class="label-column">Jilid</td>
                                                <td>: {{ $jilid->nama_jilid }}</td>
                                            </tr>
                                            <tr class="spacing-row">
                                                <td class="label-column">Tanggal</td>
                                                <td>:
                                                    {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}
                                                </td>
                                            </tr>
                                            {{-- <tr class="spacing-row">
                                                <td class="label-column">Absensi</td>
                                                <td>: {{ $jenis_absensi }}</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Santri</th>
                                                <th>Halaman</th>
                                                <th>Keterangan Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nilaiJilid as $index => $nilai)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $nilai->nama_santri }}</td>
                                                    <td>
                                                        <input type="text" name="nilai_jilid[{{ $index }}][halaman]"
                                                            class="form-control" value="{{ $nilai->halaman }}">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="nilai_jilid[{{ $index }}][id]"
                                                            value="{{ $nilai->id_nilai_jilid }}">
                                                        <input type="text"
                                                            name="nilai_jilid[{{ $index }}][keterangan_nilai]"
                                                            class="form-control" value="{{ $nilai->keterangan_nilai }}">
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                    {{-- <div class="mt-4 d-flex justify-content-between">
                                        <div>
                                            Total {{ $totalItems }} santri
                                        </div>
                                    </div> --}}

                                    <button type="submit" class="btn btn-warning mr-2 mt-3">Ubah</button>
                                    <a href="{{ route('nilai_jilid.index') }}" class="btn btn-light mt-3">Kembali</a>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection

<style>
    .radio-horizontal .radio-wrapper {
        display: inline-block;
        margin-right: 15px;
    }

    @media (max-width: 768px) {
        .radio-horizontal .radio-wrapper {
            margin-top: 10px;
        }
    }

    .table-header {
        background-color: #26747e;
        color: white;
        text-align: center;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        margin-bottom: 0;
    }

    .table {
        text-align: center;
        padding: 15px;
        border-radius: 0 0 10px 10px;
        margin-bottom: 0;
    }

    .card-body {
        padding: 0;
    }

    .table-bordered {
        border-top: none;
    }

    .label-column {
        width: 100px;
        /* Atur lebar sesuai kebutuhan Anda */
        padding-right: 10px;
        /* Jarak antara label dan data */
        text-align: left;
    }

    .spacing-row td {
        padding-top: 5px;
        /* Jarak antar baris */
        padding-bottom: 5px;
        /* Jarak antar baris */
    }
</style>
