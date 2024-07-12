@extends('master')
@section('content')
    @role('admin')
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
                                    <h3><b>Data Mata Pelajaran Diniyah</b></h3>
                                    <a href="{{ route('mapel_madin.create') }}" class="btn btn-success">Tambah</a>
                                </div>
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Kelas Madrasah Diniyah</th>
                                                <th style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mapelmadins as $no => $mapelmadin)
                                                <tr>
                                                    <td>{{ $mapelmadins->firstItem() + $no }}</td>
                                                    <td>{{ $mapelmadin->nama_mapel_madin }}</td>
                                                    <td class="d-flex flex-row align-items-stretch">
                                                        <a href="{{ route('mapel_madin.edit', $mapelmadin->id_mapel_madin) }}"
                                                            class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                        <form
                                                            action="{{ route('mapel_madin.destroy', $mapelmadin->id_mapel_madin) }}"
                                                            method="POST" class="flex-grow-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="hapus" type="submit"
                                                                class="btn btn-danger w-100">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 d-flex justify-content-between align-items-center">
                                    <div class="col-md-6">
                                        Menampilkan {{ $mapelmadins->firstItem() }} sampai {{ $mapelmadins->lastItem() }}
                                        dari
                                        total {{ $totalItems }} item
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $mapelmadins->links() }}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    @endrole
@endsection
