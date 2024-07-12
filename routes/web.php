<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSantrictrl;
use App\Http\Controllers\Paralelctrl;
use App\Http\Controllers\KamarSantrictrl;
use App\Http\Controllers\Jilidctrl;
use App\Http\Controllers\KelasMadinctrl;
use App\Http\Controllers\Pelanggaranctrl;
use App\Http\Controllers\Absensictrl;
use App\Http\Controllers\Perizinanctrl;
use App\Http\Controllers\Prestasictrl;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Userctrl;
use App\Http\Controllers\Rolesctrl;
use App\Http\Controllers\Permissionsctrl;
use App\Http\Controllers\RolePermissionctrl;
use App\Http\Controllers\Authctrl;
use App\Http\Controllers\Penilaianctrl;
use App\Http\Controllers\MapelMadinctrl;
use App\Http\Controllers\NilaiJilidctrl;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route untuk Autentikasi
Route::get('login', [Authctrl::class, 'showLoginForm'])->name('login');
Route::post('login', [Authctrl::class, 'login']);
Route::post('logout', [Authctrl::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

    // User
    Route::prefix('manajemen_users')->group(function () {
        Route::get('/user', [Userctrl::class, 'index'])->name('user.index');
        Route::get('/user/create', [Userctrl::class, 'create'])->name('user.create');
        Route::post('/user', [Userctrl::class, 'store'])->name('user.store');
        Route::get('/user/{user}/edit', [Userctrl::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [Userctrl::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [Userctrl::class, 'destroy'])->name('user.destroy');

        Route::get('/roles', [Rolesctrl::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [Rolesctrl::class, 'create'])->name('roles.create');
        Route::post('/roles', [Rolesctrl::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [Rolesctrl::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [Rolesctrl::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [Rolesctrl::class, 'destroy'])->name('roles.destroy');

        Route::get('/permissions', [Permissionsctrl::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [Permissionsctrl::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [Permissionsctrl::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{permission}/edit', [Permissionsctrl::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [Permissionsctrl::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [Permissionsctrl::class, 'destroy'])->name('permissions.destroy');

        Route::get('/role_permission', [RolePermissionctrl::class, 'index'])->name('role_permission.index');
        Route::get('/role_permission/create', [RolePermissionctrl::class, 'create'])->name('role_permission.create');
        Route::post('/role_permission', [RolePermissionctrl::class, 'store'])->name('role_permission.store');
        Route::get('/role_permission/{role}/edit', [RolePermissionctrl::class, 'edit'])->name('role_permission.edit');
        Route::put('/role_permission/{role}', [RolePermissionctrl::class, 'update'])->name('role_permission.update');
        Route::delete('/role_permission/{role}', [RolePermissionctrl::class, 'destroy'])->name('role_permission.destroy');
        Route::get('/role_permission/{id}/permissions', [RolePermissionctrl::class, 'showPermissions'])->name('role_permission.show');
    });

    // Route untuk Manajemen Data
    Route::prefix('manajemen_data')->group(function () {
        Route::get('/kamar_santri', [KamarSantrictrl::class, 'index'])->name('kamar_santri.index');
        Route::get('/kamar_santri/create', [KamarSantrictrl::class, 'create'])->name('kamar_santri.create');
        Route::post('/kamar_santri', [KamarSantrictrl::class, 'store'])->name('kamar_santri.store');
        Route::get('/kamar_santri/{kamarsantri}/edit', [KamarSantrictrl::class, 'edit'])->name('kamar_santri.edit');
        Route::put('/kamar_santri/{kamarsantri}', [KamarSantrictrl::class, 'update'])->name('kamar_santri.update');
        Route::delete('/kamar_santri/{kamarsantri}', [KamarSantrictrl::class, 'destroy'])->name('kamar_santri.destroy');

        Route::get('/paralel', [Paralelctrl::class, 'index'])->name('paralel.index');
        Route::get('/paralel/create', [Paralelctrl::class, 'create'])->name('paralel.create');
        Route::post('/paralel', [Paralelctrl::class, 'store'])->name('paralel.store');
        Route::get('/paralel/{paralel}/edit', [Paralelctrl::class, 'edit'])->name('paralel.edit');
        Route::put('/paralel/{paralel}', [Paralelctrl::class, 'update'])->name('paralel.update');
        Route::delete('/paralel/{paralel}', [Paralelctrl::class, 'destroy'])->name('paralel.destroy');

        Route::get('/jilid', [Jilidctrl::class, 'index'])->name('jilid.index');
        Route::get('/jilid/create', [Jilidctrl::class, 'create'])->name('jilid.create');
        Route::post('/jilid', [Jilidctrl::class, 'store'])->name('jilid.store');
        Route::get('/jilid/{jilid}/edit', [Jilidctrl::class, 'edit'])->name('jilid.edit');
        Route::put('/jilid/{jilid}', [Jilidctrl::class, 'update'])->name('jilid.update');
        Route::delete('/jilid/{jilid}', [Jilidctrl::class, 'destroy'])->name('jilid.destroy');

        Route::get('/kelas_madin', [KelasMadinctrl::class, 'index'])->name('kelas_madin.index');
        Route::get('/kelas_madin/create', [KelasMadinctrl::class, 'create'])->name('kelas_madin.create');
        Route::post('/kelas_madin', [KelasMadinctrl::class, 'store'])->name('kelas_madin.store');
        Route::get('/kelas_madin/{kelasmadin}/edit', [KelasMadinctrl::class, 'edit'])->name('kelas_madin.edit');
        Route::put('/kelas_madin/{kelasmadin}', [KelasMadinctrl::class, 'update'])->name('kelas_madin.update');
        Route::delete('/kelas_madin/{kelasmadin}', [KelasMadinctrl::class, 'destroy'])->name('kelas_madin.destroy');

        Route::get('/data_santri', [DataSantrictrl::class, 'index'])->name('data_santri.index');
        Route::get('/data_santri/create', [DataSantrictrl::class, 'create'])->name('data_santri.create')->middleware('can:create datasantri');
        Route::post('/data_santri', [DataSantrictrl::class, 'store'])->name('data_santri.store');
        Route::get('/data_santri/{santri}/edit', [DataSantrictrl::class, 'edit'])->name('data_santri.edit')->middleware('can:update datasantri');
        Route::put('/data_santri/{santri}', [DataSantrictrl::class, 'update'])->name('data_santri.update');
        Route::delete('/data_santri/{santri}', [DataSantrictrl::class, 'destroy'])->name('data_santri.destroy')->middleware('can:delete datasantri');
        Route::get('/data_santri/{id}/detail', [DataSantrictrl::class, 'show'])->name('data_santri.detail')->middleware('can:detail datasantri');
        Route::get('/get-santri-by-kamar', [DataSantrictrl::class, 'getSantriByKamar'])->name('getSantriByKamar');
    });

    // Route untuk Pelanggaran
    Route::prefix('pelanggaran')->group(function () {
        Route::get('/', [Pelanggaranctrl::class, 'index'])->name('pelanggaran.index');
        Route::get('/create', [Pelanggaranctrl::class, 'create'])->name('pelanggaran.create')->middleware('can:create pelanggaran');
        Route::post('/', [Pelanggaranctrl::class, 'store'])->name('pelanggaran.store');
        Route::get('/{pelanggaran}/edit', [Pelanggaranctrl::class, 'edit'])->name('pelanggaran.edit')->middleware('can:update pelanggaran');
        Route::put('/{pelanggaran}', [Pelanggaranctrl::class, 'update'])->name('pelanggaran.update');
        Route::delete('/{pelanggaran}', [Pelanggaranctrl::class, 'destroy'])->name('pelanggaran.destroy')->middleware('can:delete pelanggaran');
        Route::get('/pelanggaran/{id_santri}/riwayat', [Pelanggaranctrl::class, 'showRiwayat'])->name('pelanggaran.riwayat')->middleware('can:riwayat pelanggaran');
    });

    // Route untuk Absensi
    Route::prefix('absensi')->group(function () {
        Route::get('/', [Absensictrl::class, 'index'])->name('absensi.index');
        Route::get('/create', [Absensictrl::class, 'create'])->name('absensi.create')->middleware('can:create absensi');
        Route::post('/', [Absensictrl::class, 'store'])->name('absensi.store');
        Route::get('/{absensi}/edit', [Absensictrl::class, 'edit'])->name('absensi.edit');
        Route::put('/{absensi}', [Absensictrl::class, 'update'])->name('absensi.update');
        Route::delete('/{absensi}', [Absensictrl::class, 'destroy'])->name('absensi.destroy')->middleware('can:delete absensi');
        Route::get('/absensi/getSantriByKamar/{id_kamar}', [Absensictrl::class, 'getSantriByKamar'])->name('absensi.getSantriByKamar');
        Route::get('/{id_kamar}/riwayat/{jenis_absensi}', [Absensictrl::class, 'showRiwayat'])->name('absensi.riwayat');
        Route::post('/update-status', [Absensictrl::class, 'updateStatus'])->name('absensi.updateStatus')->middleware('can:update perizinan');
    });

    // Route untuk Perizinan
    Route::prefix('perizinan')->group(function () {
        Route::get('/', [Perizinanctrl::class, 'index'])->name('perizinan.index');
        Route::get('/create', [Perizinanctrl::class, 'create'])->name('perizinan.create')->middleware('can:create perizinan');
        Route::post('/', [Perizinanctrl::class, 'store'])->name('perizinan.store');
        Route::get('/{perizinan}/edit', [Perizinanctrl::class, 'edit'])->name('perizinan.edit')->middleware('can:update perizinan');
        Route::put('/{perizinan}', [Perizinanctrl::class, 'update'])->name('perizinan.update');
        Route::delete('/{perizinan}', [Perizinanctrl::class, 'destroy'])->name('perizinan.destroy')->middleware('can:delete perizinan');
        // Route::get('/perizinan/{id_santri}/riwayat', [Perizinanctrl::class, 'showRiwayat'])->name('perizinan.riwayat');
        Route::put('/perizinan/{id}/update-status', [Perizinanctrl::class, 'updateStatus'])->name('perizinan.updateStatus');
    });

    //Route untuk Prestasi
    Route::prefix('prestasi')->group(function () {
        Route::get('/', [Prestasictrl::class, 'index'])->name('prestasi.index');
        Route::get('/create', [Prestasictrl::class, 'create'])->name('prestasi.create')->middleware('can:create prestasi');
        Route::post('/', [Prestasictrl::class, 'store'])->name('prestasi.store');
        Route::get('/{prestasi}/edit', [Prestasictrl::class, 'edit'])->name('prestasi.edit')->middleware('can:update prestasi');
        Route::put('/{prestasi}', [Prestasictrl::class, 'update'])->name('prestasi.update');
        Route::delete('/{prestasi}', [Prestasictrl::class, 'destroy'])->name('prestasi.destroy')->middleware('can:delete prestasi');
    });

    Route::prefix('penilaian')->group(function () {
        //Route untuk Mapel Madin
        Route::prefix('mapel_madin')->group(function () {
            Route::get('/', [MapelMadinctrl::class, 'index'])->name('mapel_madin.index');
            // Route::get('/create', [MapelMadinctrl::class, 'create'])->name('mapel_madin.create')->middleware('can:create mapel_madin');
            Route::get('/create', [MapelMadinctrl::class, 'create'])->name('mapel_madin.create');
            Route::post('/', [MapelMadinctrl::class, 'store'])->name('mapel_madin.store');
            // Route::get('/{mapelmadin}/edit', [MapelMadinctrl::class, 'edit'])->name('mapel_madin.edit')->middleware('can:update mapel_madin');
            Route::get('/{mapelmadin}/edit', [MapelMadinctrl::class, 'edit'])->name('mapel_madin.edit');
            Route::put('/{mapelmadin}', [MapelMadinctrl::class, 'update'])->name('mapel_madin.update');
            Route::delete('/{mapelmadin}', [MapelMadinctrl::class, 'destroy'])->name('mapel_madin.destroy')->middleware('can:delete mapel_madin');
        });

        //Route untuk Nilai Jilid
        Route::prefix('nilai_jilid')->group(function () {
            Route::get('/', [NilaiJilidctrl::class, 'index'])->name('nilai_jilid.index');
            // Route::get('/create', [NilaiJilidctrl::class, 'create'])->name('nilai_jilid.create')->middleware('can:create nilai_jilid');
            Route::get('/create', [NilaiJilidctrl::class, 'create'])->name('nilai_jilid.create');
            Route::post('/', [NilaiJilidctrl::class, 'store'])->name('nilai_jilid.store');
            // Route::get('/{id}/edit', [NilaiJilidctrl::class, 'edit'])->name('nilai_jilid.edit')->middleware('can:update nilai_jilid');
            // Route::get('/{id}/edit', [NilaiJilidctrl::class, 'edit'])->name('nilai_jilid.edit');
            // Route::put('/{id}', [NilaiJilidctrl::class, 'update'])->name('nilai_jilid.update');
            Route::delete('/{id}', [NilaiJilidctrl::class, 'destroy'])->name('nilai_jilid.destroy')->middleware('can:delete nilai_jilid');
            Route::get('/getSantriByJilid', [NilaiJilidctrl::class, 'getSantriByJilid'])->name('getSantriByJilid');
            Route::get('/{id_jilid}/riwayat/', [NilaiJilidctrl::class, 'riwayat'])->name('nilai_jilid.riwayat');
            Route::put('/{id_jilid}/update', [NilaiJilidctrl::class, 'updateNilaiJilid'])->name('nilai_jilid.updateNilaiJilid');
        });

    });

    // Routes untuk mengedit profil
    Route::get('/profile/edit', [Userctrl::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [Userctrl::class, 'updateProfile'])->name('profile.update');

});
