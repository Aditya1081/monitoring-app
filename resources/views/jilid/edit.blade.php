@extends('master')
@section('content')
@role('admin')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Form Edit Jilid</h3>
                            <form class="forms-sample" method="POST"
                                action="{{ route('jilid.update', $jilid->id_jilid) }}" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nama_kelas">Kelas</label>
                                    <input type="text" class="form-control @error('nama_jilid') is-invalid @enderror"
                                        id="nama_jilid" name="nama_jilid" placeholder="Jilid 1"
                                        value="{{ old('nama_jilid', $jilid->nama_jilid) }}">
                                    @error('nama_jilid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-warning mr-2">Ubah</button>
                                <a href="{{ route('jilid.index') }}" class="btn btn-light">Kembali</a>
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
            $('input, select').on('input change', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });
        });
    </script>
@endrole
@endsection
