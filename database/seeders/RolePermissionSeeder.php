<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage users',
            'manage domains',
            'manage dns',
            'access customer area',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Administrator']);
        $technician = Role::firstOrCreate(['name' => 'Technician']);
        $customer = Role::firstOrCreate(['name' => 'Customer']);

        $admin->syncPermissions($permissions);
        $technician->syncPermissions(['manage domains', 'manage dns']);
        $customer->syncPermissions(['access customer area']);
    }
}
