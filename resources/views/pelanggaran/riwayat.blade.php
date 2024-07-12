@extends('master')
@section('content')
@can('index pelanggaran')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Riwayat Pelanggaran</b></h3>
                                <a href="{{ route('pelanggaran.index') }}" class="btn btn-light">Kembali</a>
                            </div>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 20%">Nama Santri</th>
                                            <th style="width: 10%">Kelas</th>
                                            <th style="width: 10%">Pelanggaran</th>
                                            <th style="width: 3%">Point</th>
                                            <th style="width: 20%">Deskripsi</th>
                                            <th style="width: 12%">Tanggal</th>
                                            @can('update pelanggaran')
                                            <th style="width: 20%">Aksi</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelanggarans as $no => $pelanggaran)
                                            <tr>
                                                <td>{{ $pelanggarans->firstItem() + $no }}</td>
                                                <td>{{ $pelanggaran->DataSantri->nama_santri }}</td>
                                                <td>{{ $pelanggaran->kamar->nama_kamar }}</td>
                                                <td>{{ $pelanggaran->nama_pelanggaran }}</td>
                                                <td>{{ $pelanggaran->point }}</td>
                                                <td>{{ $pelanggaran->deskripsi_pelanggaran ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->locale('id')->translatedFormat('d F Y') }}
                                                </td>
                                                @can('update pelanggaran')
                                                <td class="d-flex flex-row align-items-stretch">
                                                    <a href="{{ route('pelanggaran.edit', $pelanggaran->id_pelanggaran) }}"
                                                        class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                    <form
                                                        action="{{ route('pelanggaran.destroy', $pelanggaran->id_pelanggaran) }}"
                                                        method="POST" class="flex-grow-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button id="hapus" type="submit"
                                                            class="btn btn-danger w-100">Hapus</button>
                                                    </form>
                                                </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <div>
                                    Menampilkan {{ $pelanggarans->firstItem() }} sampai {{ $pelanggarans->lastItem() }}
                                    dari total {{ $totalItems }} item
                                </div>
                                <div>
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
