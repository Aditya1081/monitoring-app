@extends('master')
@section('content')
    @role('admin')
        <style>
            .btn {
                min-width: 100px;
            }

            .dropdown-container {
                display: flex;
                align-items: center;
                margin-top: 10px;
            }

            .dropdown-container label {
                margin-right: 10px;
                margin-bottom: 0;
            }

            .dropdown-container select {
                width: 80px;
                padding: 5px;
                font-size: 14px;
            }
        </style>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><b>Data Kamar</b></h3>
                                    <a href="{{ route('kamar_santri.create') }}" class="btn btn-success">Tambah</a>
                                </div>

                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Nama Kamar</th>
                                                <th style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kamarsantris as $no => $kamar)
                                                <tr>
                                                    <td>{{ $kamarsantris->firstItem() + $no }}</td>
                                                    <td>{{ $kamar->nama_kamar }}</td>
                                                    <td class="d-flex flex-row align-items-stretch">
                                                        <a href="{{ route('kamar_santri.edit', $kamar->id_kamar) }}"
                                                            class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                        <form action="{{ route('kamar_santri.destroy', $kamar->id_kamar) }}"
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
                                        Menampilkan {{ $kamarsantris->firstItem() }} sampai {{ $kamarsantris->lastItem() }}
                                        dari
                                        total {{ $totalItems }} item
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $kamarsantris->links() }}
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
