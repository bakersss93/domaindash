<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RolePermission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['manage_domains', 'manage_hosting', 'manage_ssl'];

        foreach ($permissions as $perm) {
            RolePermission::create([
                'role' => 'admin',
                'permission' => $perm,
            ]);
        }
    }
}
