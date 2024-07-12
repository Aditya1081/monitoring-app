@extends('master')
@section('content')
@can('index pelanggaran')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            @can('create pelanggaran')
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Data Pelanggaran</b></h3>
                                <a href="{{ route('pelanggaran.create') }}" class="btn btn-success">Tambah</a>
                            </div>
                            @endcan

                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">No</th>
                                            <th style="width: 42%;">Nama Santri</th>
                                            <th style="width: 20%;">Kamar</th>
                                            <th style="width: 15%;">Total Point</th>
                                            <th style="width: 20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelanggarans as $no => $pelanggaran)
                                            <tr>
                                                <td>{{ $no + 1 }}</td>
                                                <td>{{ $pelanggaran->DataSantri->nama_santri }}</td>
                                                <td>{{ $pelanggaran->kamar->nama_kamar }}</td>
                                                <td>{{ $pelanggaran->total_point }}</td>
                                                <td>
                                                    <a href="{{ route('pelanggaran.riwayat', $pelanggaran->id_santri) }}"
                                                        class="btn btn-info mb-2 mb-md-0 mr-md-2">Riwayat Pelanggaran</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="col-md-6">
                                    Menampilkan {{ $pelanggarans->firstItem() }} sampai {{ $pelanggarans->lastItem() }}
                                    dari
                                    total {{ $totalItems }} item
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    {{ $pelanggarans->links() }}
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
