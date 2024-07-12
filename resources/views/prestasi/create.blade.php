@extends('master')
@section('content')
    @can('create prestasi')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3><b>Form Data Prestasi</b></h3>
                                <form class="form-sample" action="{{ route('prestasi.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Nama Kamar</label>
                                                <div class="col-sm-9">
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
                                                <label class="col-sm-3 col-form-label">Nama Santri</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control @error('id_santri') is-invalid @enderror"
                                                        id="id_santri" name="id_santri">
                                                        <option value="">Pilih Santri</option>
                                                    </select>
                                                    @error('id_santri')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Nama Prestasi</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('nama_prestasi') is-invalid @enderror"
                                                        id="nama_prestasi" name="nama_prestasi" placeholder="Isi Prestasi"
                                                        required>
                                                    @error('nama_prestasi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                                        required></textarea>
                                                    @error('deskripsi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">Tanggal</label>
                                                <div class="col-sm-9">
                                                    <input type="date"
                                                        class="form-control @error('tanggal_prestasi') is-invalid @enderror"
                                                        id="tanggal_prestasi" name="tanggal_prestasi" required>
                                                    @error('tanggal_prestasi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label">File</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input @error('file_prestasi') is-invalid @enderror"
                                                            id="file_prestasi" name="file_prestasi"
                                                            onchange="updateFileNameLabel(this)" required>
                                                        <label class="custom-file-label" id="file_label"
                                                            for="file_prestasi">Pilih file...</label>
                                                        @error('file_prestasi')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success mr-2">Tambah</button>
                                        <a href="{{ route('prestasi.index') }}" class="btn btn-light">Kembali</a>
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

            function updateFileNameLabel(input) {
                var fileName = input.files[0].name;
                var label = document.getElementById('file_label');
                label.innerText = fileName;
            }
        </script>
    @endcan
@endsection
