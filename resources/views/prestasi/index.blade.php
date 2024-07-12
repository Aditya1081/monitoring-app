@extends('master')
@section('content')
@can('index prestasi')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            @can('create prestasi')
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Data Prestasi</b></h3>
                                <a href="{{ route('prestasi.create') }}" class="btn btn-success">Tambah</a>
                            </div>
                            @endcan

                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">No</th>
                                            <th style="width: 32%;">Nama Santri</th>
                                            <th style="width: 15%;">Kamar</th>
                                            <th style="width: 20%;">Deskripsi</th>
                                            <th style="width: 15%;">File</th>
                                            @can('update prestasi')
                                            <th style="width: 20%">Aksi</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prestasi as $no => $item)
                                            <tr>
                                                <td>{{ $prestasi->firstItem() + $no }}</td>
                                                <td>{{ $item->DataSantri->nama_santri }}</td>
                                                <td>{{ $item->kamar->nama_kamar }}</td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td><a href="{{ Storage::url($item->file_prestasi) }}"
                                                        target="_blank">Lihat File</a></td>
                                                @can('update prestasi')
                                                <td class="d-flex flex-row align-items-stretch">
                                                    <a href="{{ route('prestasi.edit', $item->id_prestasi) }}"
                                                        class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                    <form action="{{ route('prestasi.destroy', $item->id_prestasi) }}"
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

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="col-md-6">
                                    Menampilkan {{ $prestasi->firstItem() }} sampai {{ $prestasi->lastItem() }} dari total
                                    {{ $totalItems }} item
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    {{ $prestasi->links() }}
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
