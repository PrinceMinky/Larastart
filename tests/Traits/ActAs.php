<?php

namespace Tests\Traits;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

trait ActAs
{
    public function actAsSuperAdmin()
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        $user = User::factory()->create()->assignRole('Super Admin');
        $this->actingAs($user);
        return $user;
    }

    public function actAsAdmin(array $permissions = [])
    {
        $role = Role::firstOrCreate(['name' => 'User']);

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $role->givePermissionTo($permission);
        }

        $user = User::factory()->create()->assignRole('User');
        $this->actingAs($user);
        return $user;
    }

    public function actAsUser()
    {
        Role::firstOrCreate(['name' => 'User']);
        $user = User::factory()->create()->assignRole('User');
        $this->actingAs($user);
        return $user;
    }
}
