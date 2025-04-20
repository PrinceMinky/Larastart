<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of roles and permissions
        $roles = ['Super Admin', 'Admin', 'User'];
        $permissions = [
            'view admin dashboard',

            'view users', 'create users', 'edit users', 'delete users', 'export users','impersonate users',
            'view roles', 'create roles', 'edit roles', 'delete roles', 'export roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions', 'export permissions'
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assign permissions based on role
            if ($roleName === 'Super Admin') {
                $role->givePermissionTo(Permission::all());
            } elseif ($roleName === 'Admin') {
                $role->givePermissionTo([
                    'view admin dashboard',

                    'view users', 'create users', 'edit users',
                    'view roles', 
                    'view permissions',
                ]);
            }
        }
    }
}
