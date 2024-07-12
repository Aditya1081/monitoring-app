@extends('master')
@section('content')
    @role('admin')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Form Edit Mata Pelajaran Diniyah</h3>
                                <form class="forms-sample" method="POST"
                                    action="{{ route('mapel_madin.update', $mapelmadin->id_mapel_madin) }}" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="nama_kelas">Mata Pelajaran Diniyah</label>
                                        <input type="text"
                                            class="form-control @error('nama_mapel_madin') is-invalid @enderror"
                                            id="nama_mapel_madin" name="nama_mapel_madin" placeholder="Ula"
                                            value="{{ old('nama_mapel_madin', $mapelmadin->nama_mapel_madin) }}">
                                        @error('nama_mapel_madin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-warning mr-2">Ubah</button>
                                    <a href="{{ route('mapel_madin.index') }}" class="btn btn-light">Kembali</a>
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
