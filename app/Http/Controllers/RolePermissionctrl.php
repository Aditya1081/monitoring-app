<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionctrl extends Controller
{
    public function index()
    {
        $rolePermissions = Role::with('permissions')->SimplePaginate(5);
        $totalItems = Role::count();
        $permissions = Permission::all();

        $menus = [
            'Perizinan' => 'perizinan',
            'Absensi' => 'absensi',
            'Pelanggaran' => 'pelanggaran',
            'Prestasi' => 'prestasi',
            // Tambahkan menu lainnya di sini
        ];

        return view('rolePermission.index', compact('rolePermissions', 'menus', 'permissions' ,'totalItems'));
    }


    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        // Define menus
        $menus = [
            'Perizinan' => 'perizinan',
            'Absensi' => 'absensi',
            'Pelanggaran' => 'pelanggaran',
            'Prestasi' => 'prestasi',
            // Tambahkan menu lainnya di sini
        ];

        return view('rolePermission.create', compact('roles', 'permissions', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($request->role_id);

        // Fetch all permissions to ensure they belong to the correct guard
        $validPermissions = Permission::whereIn('id', $request->permissions)->where('guard_name', 'web')->pluck('id')->toArray();

        // Check if all requested permissions are valid
        if (count($validPermissions) !== count($request->permissions)) {
            return redirect()->route('role_permission.index')
                ->withErrors(['permissions' => 'Some permissions are invalid for the selected guard.']);
        }

        $role->syncPermissions($validPermissions);

        return redirect()->route('role_permission.index')
            ->with('success', 'Role permissions created successfully.');
    }


    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        $menus = [
            'Perizinan' => 'perizinan',
            'Absensi' => 'absensi',
            'Pelanggaran' => 'pelanggaran',
            'Prestasi' => 'prestasi',
            // Tambahkan menu lainnya di sini
        ];

        return view('rolePermission.edit', compact('role', 'permissions', 'rolePermissions', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = Role::findOrFail($id);

            // Pastikan izin terkait dengan guard 'web'
            $permissions = Permission::where('guard_name', 'web')->findOrFail($request->permissions);

            $role->syncPermissions($permissions);

            return redirect()->route('role_permission.index')->with('success', 'Permissions berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani exception atau kesalahan di sini
            return back()->withErrors(['error' => 'Gagal memperbarui izin.']);
        }
    }


    public function destroy(Role $role)
    {
        $role->revokePermissionTo($role->permissions);
        return redirect()->route('role_permission.index')
            ->with('success', 'Role permissions deleted successfully.');
    }


    public function showPermissions($id)
    {
        // Temukan peran berdasarkan ID
        $role = Role::findOrFail($id);

        // Tentukan menu beserta kata kunci yang terkait
        $menus = [
            'Perizinan' => 'perizinan',
            'Absensi' => 'absensi',
            'Pelanggaran' => 'pelanggaran',
            'Prestasi' => 'prestasi',
            // Tambahkan menu lainnya di sini sesuai kebutuhan
        ];

        // Ambil semua izin yang tersedia
        $allPermissions = Permission::all();

        // Ambil izin-izin yang dimiliki oleh peran
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        // Mengelompokkan izin-izin berdasarkan kategori menu
        $permissionsByMenu = [];
        foreach ($menus as $menuName => $menuKey) {
            $filteredPermissions = $allPermissions->filter(function ($permission) use ($menuKey) {
                return strpos($permission->name, $menuKey) !== false;
            })->map(function ($permission) use ($rolePermissions) {
                $permission->checked = in_array($permission->id, $rolePermissions);
                return $permission;
            });

            $permissionsByMenu[$menuName] = $filteredPermissions;
        }

        return view('rolePermission.show', compact('role', 'menus', 'permissionsByMenu'));
    }


}
