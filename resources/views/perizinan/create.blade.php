@extends('master')
@section('content')

@can('create perizinan')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><b>Form Pengajuan Perizinan</b></h3>
                            <form class="form-sample" action="{{ route('perizinan.store') }}" method="POST" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Pilih Kamar</label>
                                            <div class="col-sm-8">
                                                <select class="form-control @error('id_kamar') is-invalid @enderror"
                                                    id="id_kamar" name="id_kamar" required>
                                                    <option value="">Pilih Kamar</option>
                                                    @foreach ($kamarList as $kamar)
                                                        <option value="{{ $kamar->id_kamar }}">{{ $kamar->nama_kamar }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_kamar')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Nama Santri</label>
                                            <div class="col-sm-8">
                                                <select class="form-control @error('id_santri') is-invalid @enderror"
                                                    id="id_santri" name="id_santri" required>
                                                    <option value="">Pilih Santri</option>
                                                    <!-- Options will be loaded dynamically by JavaScript -->
                                                </select>
                                                @error('id_santri')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Nama Perizinan</label>
                                            <div class="col-sm-8">
                                                <input type="text"
                                                    class="form-control @error('nama_perizinan') is-invalid @enderror"
                                                    id="nama_perizinan" name="nama_perizinan"
                                                    placeholder="Masukkan Nama Perizinan" required>
                                                @error('nama_perizinan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Tanggal Mulai</label>
                                            <div class="col-sm-8">
                                                <input type="date"
                                                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                    id="tanggal_mulai" name="tanggal_mulai" required>
                                                @error('tanggal_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Deskripsi Perizinan</label>
                                            <div class="col-sm-8">
                                                <input type="text"
                                                    class="form-control @error('deskripsi_perizinan') is-invalid @enderror"
                                                    id="deskripsi_perizinan" name="deskripsi_perizinan"
                                                    placeholder="Masukkan Deskripsi Perizinan">
                                                @error('deskripsi_perizinan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mr-2">Tambah</button>
                                    <a href="{{ route('perizinan.index') }}" class="btn btn-light">Kembali</a>
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
            $('#id_kamar').change(function() {
                var kamarId = $(this).val();
                if (kamarId) {
                    $.ajax({
                        url: '{{ route('getSantriByKamar') }}',
                        type: 'GET',
                        data: {
                            id_kamar: kamarId
                        },
                        success: function(data) {
                            $('#id_santri').empty();
                            $('#id_santri').append('<option value="">Pilih Santri</option>');
                            $.each(data, function(key, value) {
                                $('#id_santri').append('<option value="' + value
                                    .id_santri + '">' + value.nama_santri +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#id_santri').empty();
                    $('#id_santri').append('<option value="">Pilih Santri</option>');
                }
            });
        });
    </script>
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
