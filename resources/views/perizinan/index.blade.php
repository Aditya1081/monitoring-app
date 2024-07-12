@extends('master')

@section('content')

    @can('index perizinan')
        <style>
            .btn {
                min-width: 100px;
                /* Anda bisa menyesuaikan ini jika diperlukan */
            }

            .badge {
                font-size: 14px;
                padding: 6px 10px;
                border-radius: 8px;
                color: #fff;
            }

            .custom-badge {
                display: inline-block;
                max-width: 100px;
                /* Lebar maksimum badge */
                text-align: center;
                overflow: hidden;
                /* Mengatur overflow untuk memastikan teks yang panjang dipotong */
                white-space: normal;
                /* Memastikan teks berada dalam dua baris jika perlu */
            }
        </style>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><b>Data Perizinan</b></h3>
                                    @can('create perizinan')
                                        <a href="{{ route('perizinan.create') }}" class="btn btn-success">Pengajuan</a>
                                    @endcan
                                </div>

                                <form method="GET" action="{{ route('perizinan.index') }}" class="mt-3 mb-3">
                                    <p>Pilih Data Sesuai :</p>
                                    <div class="row align-items-center">
                                        <div class="col-md-3 col-sm-6 col-6">
                                            <select name="month" class="form-control">
                                                @for ($m = 1; $m <= 12; $m++)
                                                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-6">
                                            <select name="year" class="form-control">
                                                @for ($y = 2021; $y <= \Carbon\Carbon::now()->year; $y++)
                                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12 mt-3 mt-sm-0">
                                            <button type="submit" class="btn btn-info">Tampilkan</button>
                                        </div>
                                    </div>
                                </form>

                                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pengajuan-tab" data-toggle="tab" href="#pengajuan"
                                            role="tab" aria-controls="pengajuan" aria-selected="true">Pengajuan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="diterima-tab" data-toggle="tab" href="#diterima" role="tab"
                                            aria-controls="diterima" aria-selected="false">Diterima</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ditolak-tab" data-toggle="tab" href="#ditolak" role="tab"
                                            aria-controls="ditolak" aria-selected="false">Ditolak</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="kembali-tab" data-toggle="tab" href="#kembali" role="tab"
                                            aria-controls="kembali" aria-selected="false">Kembali</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="pengajuan" role="tabpanel"
                                        aria-labelledby="pengajuan-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Lengkap</th>
                                                        <th>Kamar</th>
                                                        <th>Perihal izin</th>
                                                        <th>Mulai Izin</th>
                                                        <th>Deskripsi</th>
                                                        <th>Status</th>
                                                        @can('update perizinan')
                                                            <th>Aksi</th>
                                                        @endcan
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pengajuan as $no => $pengajuan)
                                                        <tr>
                                                            <td>{{ $no + 1 }}</td>
                                                            <td>{{ $pengajuan->DataSantri->nama_santri }}</td>
                                                            <td>{{ $pengajuan->kamar->nama_kamar }}</td>
                                                            <td>{{ $pengajuan->nama_perizinan }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            </td>
                                                            <td>{{ $pengajuan->deskripsi_perizinan ?? '-' }}</td>
                                                            <td>
                                                                <span class="badge custom-badge badge-warning">
                                                                    {{ $pengajuan->status_perizinan }}
                                                                </span>
                                                            </td>
                                                            @can('update perizinan')
                                                                <td>
                                                                    <form id="editForm{{ $pengajuan->id_perizinan }}"
                                                                        class="forms-sample" method="POST"
                                                                        action="{{ route('perizinan.update', $pengajuan->id_perizinan) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="button" class="btn btn-secondary konfirmasi"
                                                                            data-id="{{ $pengajuan->id_perizinan }}">Konfirmasi</button>
                                                                    </form>
                                                                </td>
                                                            @endcan
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Lengkap</th>
                                                        <th>Kamar</th>
                                                        <th>Perihal izin</th>
                                                        <th>Mulai Izin</th>
                                                        <th>Akhir Izin</th>
                                                        <th>Status</th>
                                                        @can('update perizinan')
                                                            <th>Aksi</th>
                                                        @endcan
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sedangIzin as $no => $sedangIzin)
                                                        <tr>
                                                            <td>{{ $no + 1 }}</td>
                                                            <td>{{ $sedangIzin->DataSantri->nama_santri }}</td>
                                                            <td>{{ $sedangIzin->kamar->nama_kamar }}</td>
                                                            <td>{{ $sedangIzin->nama_perizinan }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($sedangIzin->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($sedangIzin->tanggal_akhir)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-success">
                                                                    {{ $sedangIzin->status_perizinan }}
                                                                </span>
                                                            </td>
                                                            @can('update perizinan')
                                                                <td>
                                                                    <form id="editForm{{ $sedangIzin->id_perizinan }}"
                                                                        class="forms-sample" method="POST"
                                                                        action="{{ route('perizinan.updateStatus', $sedangIzin->id_perizinan) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="button"
                                                                            class="btn btn-secondary konfirmasi_kembali"
                                                                            data-id="{{ $sedangIzin->id_perizinan }}">Konfirmasi
                                                                            Kembali</button>
                                                                    </form>

                                                                </td>
                                                            @endcan
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ditolak" role="tabpanel" aria-labelledby="ditolak-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Lengkap</th>
                                                        <th>Kamar</th>
                                                        <th>Perihal izin</th>
                                                        <th>Mulai Izin</th>
                                                        <th>Status</th>
                                                        <th>Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($izinDitolak as $no => $izinDitolak)
                                                        <tr>
                                                            <td>{{ $no + 1 }}</td>
                                                            <td>{{ $izinDitolak->DataSantri->nama_santri }}</td>
                                                            <td>{{ $izinDitolak->kamar->nama_kamar }}</td>
                                                            <td>{{ $izinDitolak->nama_perizinan }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izinDitolak->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-danger">
                                                                    {{ $izinDitolak->status_perizinan }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $izinDitolak->deskripsi_pengurus ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kembali" role="tabpanel" aria-labelledby="kembali-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Lengkap</th>
                                                        <th>Kamar</th>
                                                        <th>Perihal izin</th>
                                                        <th>Mulai Izin</th>
                                                        <th>Akhir Izin</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($izinSelesai as $no => $izinSelesai)
                                                        <tr>
                                                            <td>{{ $no + 1 }}</td>
                                                            <td>{{ $izinSelesai->DataSantri->nama_santri }}</td>
                                                            <td>{{ $izinSelesai->kamar->nama_kamar }}</td>
                                                            <td>{{ $izinSelesai->nama_perizinan }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izinSelesai->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($izinSelesai->tanggal_akhir)->locale('id')->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>
                                                                @if ($izinSelesai->status_perizinan == 'Tepat Waktu')
                                                                    <span class="badge badge-success">
                                                                        {{ $izinSelesai->status_perizinan }}
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-danger">
                                                                        {{ $izinSelesai->status_perizinan }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    // Set CSRF token in all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.konfirmasi').on('click', function(e) {
            e.preventDefault();
            var formId = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi Perizinan',
                html: 'Diizinkan sampai tanggal : <input id="swal-input1" class="swal2-input" type="date">',
                showCancelButton: true,
                confirmButtonText: 'Setujui',
                cancelButtonText: 'Tolak',
                preConfirm: () => {
                    return document.getElementById('swal-input1').value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Add the date to a hidden input in the form
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'tanggal_akhir',
                        value: result.value
                    }).appendTo('#editForm' + formId);
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'status_perizinan',
                        value: 'Disetujui'
                    }).appendTo('#editForm' + formId);
                    $('#editForm' + formId).submit(); // Submit the form
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Masukkan Alasan',
                        input: 'textarea',
                        inputPlaceholder: 'Masukkan alasan Anda di sini...',
                        inputAttributes: {
                            'aria-label': 'Masukkan alasan Anda di sini'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Tolak',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Add the reason to a hidden input in the form
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'deskripsi_pengurus',
                                value: result.value
                            }).appendTo('#editForm' + formId);
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'status_perizinan',
                                value: 'Ditolak'
                            }).appendTo('#editForm' + formId);
                            $('#editForm' + formId).submit(); // Submit the form
                        }
                    });
                }
            });
        });

        $('.konfirmasi_kembali').on('click', function(e) {
            e.preventDefault();
            var formId = $(this).data('id');

            // Tentukan nilai status_perizinan berdasarkan kelas tombol yang ditekan
            var statusPerizinan = $(this).hasClass('konfirmasi_datang_terlambat') ? 'Datang Terlambat' :
                'Tepat Waktu';

            // Tambahkan nilai status_perizinan sebagai input tersembunyi
            $('<input>').attr({
                type: 'hidden',
                name: 'status_perizinan',
                value: statusPerizinan
            }).appendTo('#editForm' + formId);

            // Submit form
            $('#editForm' + formId).submit();
        });

    });
</script>
