@extends('master')

@section('content')

    @can('index absensi')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('absensi.updateStatus') }}" method="POST">
                                    @csrf
                                    <div class="table-responsive pt-3">
                                        <div class="table-header text-center p-3">
                                            <h3><b>DATA ABSENSI</b></h3>
                                        </div>
                                    </div>

                                    <table class="my-3">
                                        <tbody>
                                            <tr class="spacing-row">
                                                <td class="label-column">Kamar</td>
                                                <td>: {{ $kamar->nama_kamar }}</td>
                                            </tr>
                                            <tr class="spacing-row">
                                                <td class="label-column">Tanggal</td>
                                                <td>:
                                                    {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}
                                                </td>
                                            </tr>
                                            <tr class="spacing-row">
                                                <td class="label-column">Absensi</td>
                                                <td>: {{ $jenis_absensi }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Nama Santri</th>
                                                <th>Status Absensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($absensis as $index => $absensi)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $absensi->dataSantri->nama_santri }}</td>
                                                    <td class="radio-horizontal">
                                                        <input type="hidden" name="absensi[{{ $absensi->id_absensi }}][id]"
                                                            value="{{ $absensi->id_absensi }}">
                                                        <div class="radio-wrapper">
                                                            <input type="radio"
                                                                name="absensi[{{ $absensi->id_absensi }}][status]"
                                                                value="hadir"
                                                                {{ $absensi->status_absensi == 'hadir' ? 'checked' : '' }}>
                                                            <label for="hadir">Hadir</label>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <input type="radio"
                                                                name="absensi[{{ $absensi->id_absensi }}][status]"
                                                                value="tidak hadir"
                                                                {{ $absensi->status_absensi == 'tidak hadir' ? 'checked' : '' }}>
                                                            <label for="tidak_hadir">Alpa</label>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <input type="radio"
                                                                name="absensi[{{ $absensi->id_absensi }}][status]"
                                                                value="sakit"
                                                                {{ $absensi->status_absensi == 'sakit' ? 'checked' : '' }}>
                                                            <label for="sakit">Sakit</label>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <input type="radio"
                                                                name="absensi[{{ $absensi->id_absensi }}][status]"
                                                                value="izin"
                                                                {{ $absensi->status_absensi == 'izin' ? 'checked' : '' }}>
                                                            <label for="izin">Izin</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>


                                    <div class="mt-4 d-flex justify-content-between">
                                        <div>
                                            Total {{ $totalItems }} santri
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning mr-2 mt-3">Ubah</button>
                                    <a href="{{ route('absensi.index') }}" class="btn btn-light mt-3">Kembali</a>

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
</style>

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
        border-radius: 10px 10px 0 0;
        margin-bottom: 0;
    }

    .table {
        text-align: center;
        padding: 15px;
        border-radius: 0 0 10px 10px;
        margin-bottom: 0;
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
