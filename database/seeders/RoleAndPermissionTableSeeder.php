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
            'view dashboard',

            'view admin dashboard',

            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
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
                $role->givePermissionTo(['view dashboard', 'view admin dashboard']);
            } elseif ($roleName === 'User') {
                $role->givePermissionTo(['view dashboard']);
            }
        }
    }
}
