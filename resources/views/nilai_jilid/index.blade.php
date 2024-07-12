@extends('master')

@section('content')
    <style>
        .btn {
            min-width: 100px;
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{-- @can('create absensi') --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><b>Data Penilaian Jilid</b></h3>
                                <a href="{{ route('nilai_jilid.create') }}" class="btn btn-success">Tambah</a>
                            </div>
                            {{-- @endcan --}}

                            <form action="{{ route('nilai_jilid.index') }}" method="GET" class="form-inline">
                                <div class="form-group">
                                    <label for="tanggal" class="mr-2">Pilih Tanggal:</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="{{ $tanggal ?? date('d-m-Y') }}" onchange="this.form.submit()">
                                </div>
                            </form>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kelas TPQ</th>
                                            <th>Tanggal Penilaian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($nilaiJilid as $index => $nilai)
                                            <tr>
                                                <td>{{ $nilaiJilid->firstItem() + $index }}</td>
                                                <td>{{ $nilai->nama_jilid }}</td>
                                                <td>{{ \Carbon\Carbon::parse($nilai->tanggal_penilaian)->locale('id')->translatedFormat('d F Y') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('nilai_jilid.riwayat', ['id_jilid' => $nilai->id_jilid, 'tanggal' => isset($tanggal) ? $tanggal : date('d-m-Y')]) }}"
                                                        class="btn btn-info mb-2 mb-md-0 mr-md-2">Data Penilaian</a>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Data nilai jilid tidak ditemukan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4 d-flex justify-content-between">
                                    <div>
                                        {{ $nilaiJilid->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
