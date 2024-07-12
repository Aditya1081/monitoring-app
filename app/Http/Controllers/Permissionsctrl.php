<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class Permissionsctrl extends Controller
{
    // public function index()
    // {
    //     $totalItems = Permission::count();
    //     // $permissions = Permission::SimplePaginate(5);
    //     $permissions = Permission::paginate(5);
    //     return view('permissions.index', compact('permissions', 'totalItems'));
    // }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5); // Default 5 jika tidak ada input
        $totalItems = Permission::count();
        $permissions = Permission::simplePaginate($perPage)->appends(['perPage' => $perPage]);
        return view('permissions.index', compact('permissions', 'totalItems', 'perPage'));
    }


    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
