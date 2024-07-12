@extends('master')

@section('content')

    @can('create absensi')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3><b>Form Absensi</b></h3>
                                <form id="createForm" class="forms-sample" action="{{ route('absensi.store') }}" method="POST">

                                    <!-- Pesan Error dari Session -->
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @csrf
                                    <div class="form-group">
                                        <label for="id_kamar">Kamar</label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-control @error('id_kamar') is-invalid @enderror" id="id_kamar"
                                                name="id_kamar">
                                                <option value="">Pilih Kamar</option>
                                                @foreach ($kamarList as $kamar)
                                                    <option value="{{ $kamar->id_kamar }}">{{ $kamar->nama_kamar }}</option>
                                                @endforeach
                                            </select>
                                            <span class="custom-arrow">&gt;</span>
                                        </div>
                                        @error('id_kamar')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_absensi">Jenis Absensi</label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-control @error('jenis_absensi') is-invalid @enderror"
                                                id="jenis_absensi" name="jenis_absensi">
                                                <option value="">Pilih Jenis Absensi</option>
                                                <option value="Pagi">Pagi</option>
                                                <option value="Sore">Sore</option>
                                            </select>
                                            <span class="custom-arrow">&gt;</span>
                                        </div>
                                        @error('jenis_absensi')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_absensi">Tanggal Absensi</label>
                                        <input class="form-control @error('tanggal_absensi') is-invalid @enderror"
                                            type="date" id="tanggal_absensi" name="tanggal_absensi">
                                        @error('tanggal_absensi')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Tabel untuk menampilkan nama santri dan status absensi -->
                                    <div class="mt-4">
                                        <h4>Daftar Santri</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Santri</th>
                                                    <th>Status Absensi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="santriTableBody">
                                                <!-- Data santri akan ditampilkan di sini via Ajax -->
                                            </tbody>
                                        </table>

                                        <div class="form-group" id="Pesan-Data-Kosong" style="display: none; color: red;">
                                            Tidak ada data santri yang ditemukan untuk kamar <span
                                                id="Nama-Kamar-dipilih"></span>
                                        </div>

                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success mr-2" id="tambah">Tambah</button>
                                        <button type="button" class="btn btn-light"
                                            onclick="window.location='{{ route('absensi.index') }}'">Kembali</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                function updateJenisAbsensi(jenisAbsensi) {
                    $('#santriTableBody').find('.jenis-absensi').each(function() {
                        $(this).val(jenisAbsensi);
                    });
                }

                function updateTanggalAbsensi(tanggalAbsensi) {
                    $('#santriTableBody').find('.tanggal-absensi').each(function() {
                        $(this).val(tanggalAbsensi);
                    });
                }

                $('#id_kamar').change(function() {
                    var kamarId = $(this).val();
                    var NamaKamar = $('#id_kamar option:selected').text();
                    if (kamarId) {
                        $.ajax({
                            url: '{{ route('getSantriByKamar') }}',
                            type: 'GET',
                            data: {
                                id_kamar: kamarId
                            },
                            success: function(data) {
                                $('#santriTableBody').empty();
                                var jenisAbsensi = $('#jenis_absensi').val();
                                var tanggalAbsensi = $('#tanggal_absensi').val();
                                if (data.length === 0) {
                                    $('#Pesan-Data-Kosong').show();
                                    $('#Nama-Kamar-dipilih').text(NamaKamar);
                                } else {
                                    $('#Pesan-Data-Kosong').hide();
                                    $.each(data, function(key, value) {
                                        $('#santriTableBody').append(
                                            '<tr>' +
                                            '<td>' + value.nama_santri + '</td>' +
                                            '<input type="hidden" name="jenis_absensi[' +
                                            value.id_santri + ']" value="' +
                                            jenisAbsensi +
                                            '" class="jenis-absensi">' +
                                            '<input type="hidden" name="tanggal_absensi[' +
                                            value.id_santri + ']" value="' +
                                            tanggalAbsensi +
                                            '" class="tanggal-absensi">' +
                                            '<td class="radio-horizontal">' +
                                            '<div class="radio-wrapper"><input type="radio" name="status_absensi[' +
                                            value.id_santri +
                                            ']" value="hadir"> Hadir </div>' +
                                            '<div class="radio-wrapper"><input type="radio" name="status_absensi[' +
                                            value.id_santri +
                                            ']" value="tidak hadir"> Alpa </div>' +
                                            '<div class="radio-wrapper"><input type="radio" name="status_absensi[' +
                                            value.id_santri +
                                            ']" value="sakit"> Sakit </div>' +
                                            '<div class="radio-wrapper"><input type="radio" name="status_absensi[' +
                                            value.id_santri +
                                            ']" value="izin"> Izin </div>' +
                                            '</td>' +
                                            '</tr>'
                                        );
                                    });
                                }
                            }
                        });
                    } else {
                        $('#santriTableBody').empty();
                        $('#Pesan-Data-Kosong').hide();
                    }
                });

                $('#jenis_absensi').change(function() {
                    var jenisAbsensi = $(this).val();
                    updateJenisAbsensi(jenisAbsensi);
                });

                $('#tanggal_absensi').change(function() {
                    var tanggalAbsensi = $(this).val();
                    updateTanggalAbsensi(tanggalAbsensi);
                });
            });
        </script>

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
    @endcan

@endsection

<style>
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 100%;
        padding-right: 30px;
        background-color: transparent;
        /* Optional, to match the input type "date" style */
    }

    .custom-arrow {
        position: absolute;
        top: 50%;
        right: 30px;
        transform: translateY(-50%) rotate(0deg);
        transition: transform 0.3s ease;
        pointer-events: none;
        font-size: 16px;
        /* color: #26747e; */
        color: black;
    }

    .custom-select-wrapper select:focus+.custom-arrow {
        transform: translateY(-50%) rotate(90deg);
    }

    .custom-select-wrapper.select.is-invalid select {
        border-color: #dc3545;
    }
</style>
