@extends('master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Form Penilaian Jilid</b></h3>
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="createForm" class="forms-sample" action="{{ route('nilai_jilid.store') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="id_jilid">Jilid</label>
                                    <div class="custom-select-wrapper">
                                        <select class="form-control @error('id_jilid') is-invalid @enderror" id="id_jilid"
                                            name="id_jilid" required>
                                            <option value="">Pilih Jilid</option>
                                            @foreach ($jilidList as $jilid)
                                                <option value="{{ $jilid->id_jilid }}">{{ $jilid->nama_jilid }}</option>
                                            @endforeach
                                        </select>
                                        <span class="custom-arrow">&gt;</span>
                                        @error('id_jilid')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_penilaian">Tanggal Penilaian</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_penilaian') is-invalid @enderror"
                                        id="tanggal_penilaian" name="tanggal_penilaian">
                                    @error('tanggal_penilaian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tabel untuk menampilkan data santri -->
                                <div class="mt-4">
                                    <h4>Daftar Santri</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Santri</th>
                                                <th>Halaman</th>
                                                <th>Keterangan Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody id="santriTableBody">
                                            <!-- Data santri akan ditampilkan di sini via Ajax -->
                                        </tbody>
                                    </table>

                                    <div class="form-group" id="Pesan-Data-Kosong" style="display: none; color: red;">
                                        Tidak ada data santri yang ditemukan untuk jilid <span
                                            id="Nama-Jilid-dipilih"></span>
                                    </div>

                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success mr-2" id="tambah">Tambah</button>
                                    <a href="{{ route('nilai_jilid.index') }}" class="btn btn-light">Kembali</a>
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
            $('#id_jilid').change(function() {
                var jilidId = $(this).val();
                var namaJilid = $('#id_jilid option:selected').text();
                if (jilidId) {
                    $.ajax({
                        url: '{{ route('getSantriByJilid') }}',
                        type: 'GET',
                        data: {
                            id_jilid: jilidId
                        },
                        success: function(data) {
                            $('#santriTableBody').empty();
                            var tanggalPenilaian = $('#tanggal_penilaian').val();
                            if (data.length === 0) {
                                $('#Pesan-Data-Kosong').show();
                                $('#Nama-Jilid-dipilih').text(namaJilid);
                            } else {
                                $('#Pesan-Data-Kosong').hide();
                                $.each(data, function(key, value) {
                                    $('#santriTableBody').append(
                                        '<tr>' +
                                        '<td>' + value.nama_santri + '</td>' +
                                        '<input type="hidden" name="tanggal_penilaian[' +
                                        value.id_santri.toString() + ']" value="' +
                                        tanggalPenilaian +
                                        '" class="tanggal-penilaian">' +
                                        '<td>' +
                                        '<input type="text" name="halaman[' + value
                                        .id_santri.toString() +
                                        ']" class="form-control">' +
                                        '</td>' +
                                        '<td>' +
                                        '<input type="text" name="keterangan_nilai[' +
                                        value.id_santri.toString() +
                                        ']" class="form-control">' +
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

            $('#tanggal_penilaian').change(function() {
                var tanggalPenilaian = $(this).val();
                $('#santriTableBody').find('.tanggal-penilaian').each(function() {
                    $(this).val(tanggalPenilaian);
                });
            });
        });
    </script>

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
        }

        .custom-arrow {
            position: absolute;
            top: 50%;
            right: 30px;
            transform: translateY(-50%) rotate(0deg);
            transition: transform 0.3s ease;
            pointer-events: none;
            font-size: 16px;
            color: black;
        }

        .custom-select-wrapper select:focus+.custom-arrow {
            transform: translateY(-50%) rotate(90deg);
        }

        .custom-select-wrapper.select.is-invalid select {
            border-color: #dc3545;
        }
    </style>
@endsection
