@extends('master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Selamat Datang Wali Santri dari {{ $dataSantri->nama_santri }}
                </h4>
                <p class="font-weight-normal mb-2 text-muted">{{ $currentDate }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 grid-margin stretch-card">
                <div class="card card-custom" style="border-radius: 10px">
                    <div class="text-container align-items-center">
                        <h3 class="font-weight-bold text-dark" style="padding-top: 10px">Data Santri</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset('assets/images/faces/face7.jpg') }}" alt="Face Image" class="img-fluid" style="width: 100%; max-width: 500px; height: auto; border-radius: 10px; margin-bottom: 10px; margin-top: 10px;">
                            </div>
                            <div class="col-md-9">
                                <table class=" table table-borderless">
                                    <tbody>
                                        <tr class="spacing-row">
                                            <td class="label-column"><strong>Nama Santri</strong></td>
                                            <td>: {{ $dataSantri->nama_santri }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIS</strong></td>
                                            <td>: {{ $dataSantri->NIS }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Wali Santri</strong></td>
                                            <td>: {{ $dataSantri->nama_wali_santri }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. Telp Wali</strong></td>
                                            <td>: {{ $dataSantri->no_telp_wali }}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>No. VA</strong></td>
                                            <td>: {{ $dataSantri->no_va }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kamar</strong></td>
                                            <td>: {{ $dataSantri->kamarSantri->nama_kamar }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kelas</strong></td>
                                            <td>: {{ $dataSantri->kelasSantri->nama_kelas }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kelas Madin</strong></td>
                                            <td>: {{ $dataSantri->madinSantri->nama_kelas_madin }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kelas Jilid</strong></td>
                                            <td>: {{ $dataSantri->jilidSantri->nama_jilid }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Total Pengajuan Perizinan -->
            <div class="col-xl-6 grid-margin stretch-card">
                <div class="card" style="border-radius: 10px; ">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-container">
                            <!-- Inline SVG with fill color set to orange -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="100%" width="100px" fill="orange" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zm48 96a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 240a24 24 0 1 0 0-48 24 24 0 1 0 0 48zM368 321.6V328c0 8.8 7.2 16 16 16s16-7.2 16-16v-6.4c0-5.3 4.3-9.6 9.6-9.6h40.5c7.7 0 13.9 6.2 13.9 13.9c0 5.2-2.9 9.9-7.4 12.3l-32 16.8c-5.3 2.8-8.6 8.2-8.6 14.2V384c0 8.8 7.2 16 16 16s16-7.2 16-16v-5.1l23.5-12.3c15.1-7.9 24.5-23.6 24.5-40.6c0-25.4-20.6-45.9-45.9-45.9H409.6c-23 0-41.6 18.6-41.6 41.6z" />
                            </svg>
                        </div>
                        <div class="text-container ml-3 align-items-center">
                            <div>
                                <h1 class="font-weight-bold text-dark">{{ $totalPengajuanPerizinan }}</h1>
                            </div>
                            <p class="text-muted m-0">Total Pengajuan Perizinan</p>
                            <p class="text-muted m-0">Per-Bulan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 grid-margin stretch-card">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-container">
                            <!-- Inline SVG with fill color set to orange -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="100%" width="100px" fill="red" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zm48 96a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 240a24 24 0 1 0 0-48 24 24 0 1 0 0 48zm0-192c-8.8 0-16 7.2-16 16v80c0 8.8 7.2 16 16 16s16-7.2 16-16V288c0-8.8-7.2-16-16-16z" />
                            </svg>
                        </div>
                        <div class="text-container ml-3 align-items-center">
                            <div>
                                <h1 class="font-weight-bold text-dark">{{ $rekapPelanggaranBulanan }}</h1>
                            </div>
                            <p class="text-muted m-0">Total Pelanggaran</p>
                            <p class="text-muted m-0">Per-Bulan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .row {
        display: flex;
        justify-content: space-between;
        padding: 5px;
    }

    .card {
        padding: 15px;
        flex: 1;
    }

    .icon-container {
        flex: 0 0 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .text-container {
        flex: 1;
        text-align: left;
        margin: 10px;
    }

    .font-weight-bold {
        font-weight: bold;
    }

    .text-dark {
        color: #000;
    }

    .text-green {
        color: green;
    }

    .label-column {
        width: 170px;
        padding-right: 10px;
        text-align: left;
    }

    .spacing-row td {
        padding-top: 5px;
        padding-bottom: 5px;
    }
</style>