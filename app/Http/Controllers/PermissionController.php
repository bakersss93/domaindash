<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RolePermission;

class PermissionController extends Controller
{
    private array $availablePermissions = [
        'manage_domains',
        'manage_hosting',
        'manage_ssl',
    ];

    private array $roles = ['admin', 'technician', 'customer'];

    public function edit()
    {
        $rolePermissions = RolePermission::all()->groupBy('role');

        return view('admin.permissions.edit', [
            'permissions' => $this->availablePermissions,
            'roles' => $this->roles,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->input('permissions', []);

        foreach ($this->roles as $role) {
            RolePermission::where('role', $role)->delete();
            if (! empty($data[$role])) {
                foreach ($data[$role] as $permission) {
                    RolePermission::create([
                        'role' => $role,
                        'permission' => $permission,
                    ]);
                }
            }
        }

        return redirect()->route('permissions.edit')->with('success', 'Permissions updated.');
    }
}
