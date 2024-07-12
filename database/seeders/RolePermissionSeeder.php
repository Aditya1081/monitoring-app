<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'index perizinan']);
        Permission::create(['name' => 'create perizinan']);
        Permission::create(['name' => 'update perizinan']);
        Permission::create(['name' => 'delete perizinan']);
        Permission::create(['name' => 'index pelanggaran']);
        Permission::create(['name' => 'create pelanggaran']);
        Permission::create(['name' => 'update pelanggaran']);
        Permission::create(['name' => 'delete pelanggaran']);
        Permission::create(['name' => 'riwayat pelanggaran']);
        Permission::create(['name' => 'index absensi']);
        Permission::create(['name' => 'create absensi']);
        Permission::create(['name' => 'update absensi']);
        Permission::create(['name' => 'delete absensi']);
        Permission::create(['name' => 'index prestasi']);
        Permission::create(['name' => 'create prestasi']);
        Permission::create(['name' => 'update prestasi']);
        Permission::create(['name' => 'delete prestasi']);
        Permission::create(['name' => 'index penilaian']);
        Permission::create(['name' => 'create penilaian']);
        Permission::create(['name' => 'update penilaian']);
        Permission::create(['name' => 'delete penilaian']);
        Permission::create(['name' => 'index datasantri']);
        Permission::create(['name' => 'create datasantri']);
        Permission::create(['name' => 'update datasantri']);
        Permission::create(['name' => 'delete datasantri']);
        Permission::create(['name' => 'detail datasantri']);
        
        // Create roles and assign created permissions

        // User role
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['index perizinan', 'create perizinan', 'index pelanggaran', 'index absensi', 'index prestasi', 'index penilaian', 'index datasantri']);

        // Pengurus role
        $pengurusRole = Role::create(['name' => 'pengurus']);
        $pengurusRole->givePermissionTo(['index absensi', 'create absensi', 'update absensi', 'delete absensi', 'index perizinan', 'update perizinan', 'delete perizinan', 'index pelanggaran', 'create pelanggaran', 'update pelanggaran', 'delete pelanggaran', 'riwayat pelanggaran']);

        // Ustadz role
        $ustadzRole = Role::create(['name' => 'ustadz']);
        $ustadzRole->givePermissionTo(['index absensi', 'create absensi', 'update absensi', 'delete absensi', 'index penilaian', 'create penilaian', 'update penilaian', 'delete penilaian']);

        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
