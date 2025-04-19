<?php

use App\Livewire\Admin\UserManagement\Permissions;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user with correct permissions can access permissions screen', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'view permissions']);
    $role->syncPermissions('view permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $response = $this->actingAs($user)->get(route('admin.user.permission'));

    $response->assertStatus(200);
});

test('unauthorized user cannot access permissions screen', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    $response = $this->actingAs($user)->get(route('admin.user.permission'));

    $response->assertStatus(403);
});

test('user with correct permissions can create a permission', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'create permissions']);
    $role->syncPermissions('create permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)->test(Permissions::class)
        ->set('name', 'Permission Name')
        ->call('save');

    $this->assertDatabaseHas('permissions', [
        'name' => 'Permission Name',
    ]);
});

test('user with correct permissions can create multiple permissions', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'create permissions']);
    $role->syncPermissions('create permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)->test(Permissions::class)
        ->set('name', 'Permission Name|Another Permission Name')
        ->call('save');

    $this->assertDatabaseHas('permissions', [
        'name' => 'Permission Name',
    ]);

    $this->assertDatabaseHas('permissions', [
        'name' => 'Another Permission Name',
    ]);
});

test('user with correct permissions can create multiple permissions as a resource', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'create permissions']);
    $role->syncPermissions('create permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)->test(Permissions::class)
        ->set('name', 'test 1|test 2')
        ->set('createResource', true)
        ->call('save');

    foreach (['view', 'create', 'edit', 'delete'] as $action) {
        foreach (['test 1', 'test 2'] as $permission) {
            $this->assertDatabaseHas('permissions', [
                'name' => "$action $permission",
            ]);
        }
    }
});

test('user with correct permissions can update a permission', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'edit permissions']);
    $role->syncPermissions('edit permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $permission = Permission::create(['name' => 'Old Permission Name']);

    Livewire::actingAs($user)
        ->test(Permissions::class)
        ->set('permissionId', $permission->id)
        ->set('name', 'Updated Permission Name')
        ->call('save');

    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
        'name' => 'Updated Permission Name',
    ]);
});

test('user with correct permissions can delete a permission', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'delete permissions']);
    $role->syncPermissions('delete permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $permission = Permission::create(['name' => 'Role To Delete']);

    Livewire::actingAs($user)
        ->test(Permissions::class)
        ->set('permissionId', $permission->id)
        ->call('delete');

    $this->assertDatabaseMissing('permissions', [
        'id' => $permission->id,
    ]);
});

test('user with correct permissions can delete multiple permissions', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'delete permissions']);
    $role->syncPermissions('delete permissions');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $permissions = [
        Permission::create(['name' => 'Permission To Delete']),
        Permission::create(['name' => '2nd Permission To Delete']),
        Permission::create(['name' => '3rd Permission To Delete']),
    ];

    Livewire::actingAs($user)
        ->test(Permissions::class)
        ->set('selectedPermissionIds', collect($permissions)->pluck('id')->toArray())
        ->call('deleteSelected');

    foreach ($permissions as $permission) {
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }
});

test('unauthorized user cannot create a permission', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    Livewire::actingAs($user)->test(Permissions::class)
        ->set('name', 'Unauthorized Permission')
        ->call('save');

    $this->assertDatabaseMissing('permissions', [
        'name' => 'Unauthorized Permission',
    ]);
});

test('unauthorized user cannot update a permission', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    $permission = Permission::create(['name' => 'Permission To Update']);

    Livewire::actingAs($user)->test(Permissions::class)
        ->set('permissionId', $permission->id)
        ->set('name', 'Updated Permission Name')
        ->call('save');

    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
        'name' => 'Permission To Update', // Ensuring the name did not change
    ]);
});

test('unauthorized user cannot delete a permission', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    $permission = Permission::create(['name' => 'Permission To Delete']);

    Livewire::actingAs($user)
        ->test(Permissions::class)
        ->set('permissionId', $permission->id)
        ->call('delete');

    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
    ]);
});
