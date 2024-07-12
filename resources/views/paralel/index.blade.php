@extends('master')
@section('content')
    @role('admin')
        <style>
            .btn {
                min-width: 100px;
                /* Anda bisa menyesuaikan ini jika diperlukan */
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
                                    <h3><b>Data Kelas</b></h3>
                                    <a href="{{ route('paralel.create') }}" class="btn btn-success">Tambah</a>
                                </div>

                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Kelas</th>
                                                <th style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paralels as $no => $paralel)
                                                <tr>
                                                    <td>{{ $paralels->firstItem() + $no }}</td>
                                                    <td>{{ $paralel->nama_kelas }}</td>
                                                    <td class="d-flex flex-row align-items-stretch">
                                                        <a href="{{ route('paralel.edit', $paralel->id_kelas) }}"
                                                            class="btn btn-warning mr-2 flex-grow-1" id="ubah">Ubah</a>
                                                        <form action="{{ route('paralel.destroy', $paralel->id_kelas) }}"
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
                                        Menampilkan {{ $paralels->firstItem() }} sampai {{ $paralels->lastItem() }}
                                        dari
                                        total {{ $totalItems }} item
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $paralels->links() }}
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
