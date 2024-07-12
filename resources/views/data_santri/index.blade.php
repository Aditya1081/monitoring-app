@extends('master')
@section('content')
@role('admin')
<style>
    .btn {
        min-width: 70px;
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
                            <h3><b>Data Santri</b></h3>
                            <a href="{{ route('data_santri.create') }}" class="btn btn-success">Tambah</a>
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 3%;">No</th>
                                        <th style="width: 20%;">Nama Santri</th>
                                        <th style="width: 9%;">Kamar</th>
                                        <th style="width: 10%;">Kelas Madin</th>
                                        <th style="width: 10%;">Kelas TPQ</th>
                                        <th style="width: 10%;">No.Telp Wali</th>
                                        <th style="width: 20%;">Alamat</th>
                                        <th style="width: 8%;">No VA</th>
                                        <th style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($santris as $no => $santri)
                                    <tr>
                                        <td>{{ $santris->firstItem() + $no }}</td>
                                        <td>{{ $santri->nama_santri }}</td>
                                        <td>{{ $santri->kamarSantri->nama_kamar }}</td>
                                        <td class="text-center">{{ $santri->madinSantri->nama_kelas_madin ?? '-' }}
                                        </td>
                                        <td class="text-center">{{ $santri->jilidSantri->nama_jilid ?? '-' }}</td>
                                        <td>{{ $santri->no_telp_wali }}</td>
                                        <td>{{ $santri->alamat }}</td>
                                        <td>8241002201150001</td>
                                        <td class="d-flex flex-column align-items-stretch">

                                            <form action="{{ route('data_santri.detail', $santri->id_santri) }}" method="GET" class="mb-2 w-100">
                                                <button type="submit" class="btn btn-info w-100">Lihat</button>
                                            </form>

                                            <a href="{{ route('data_santri.edit', $santri->id_santri) }}" class="btn btn-warning mb-2 w-100" id="ubah" style="color: white;">Ubah</a>

                                            <form action="{{ route('data_santri.destroy', $santri->id_santri) }}" method="POST" class="w-100">
                                                @csrf
                                                @method('DELETE')
                                                <button id="hapus" type="submit" class="btn btn-danger w-100">Hapus</button>
                                            </form>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div class="col-md-6">
                                Menampilkan {{ $santris->firstItem() }} sampai {{ $santris->lastItem() }} dari total
                                {{ $totalItems }} item
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                {{ $santris->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>>
</div>
@endrole
@endsection