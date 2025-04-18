<?php

use App\Livewire\Admin\UserManagement\Roles;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user with correct permissions can access roles screen', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'view roles']);
    $role->syncPermissions('view roles');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $response = $this->actingAs($user)->get(route('admin.user.role'));

    $response->assertStatus(200);
});

test('unauthorized user cannot access roles screen', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    $response = $this->actingAs($user)->get(route('admin.user.role'));

    $response->assertStatus(403);
});

test('user with correct permissions can create a role', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'create roles']);
    $role->syncPermissions('create roles');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)->test(Roles::class)
        ->set('name', 'Role Name')
        ->call('save');

    $this->assertDatabaseHas('roles', [
        'name' => 'Role Name',
    ]);
});

test('user with correct permissions can update a role', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'edit roles']);
    $role->syncPermissions('edit roles');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $roleToUpdate = Role::create(['name' => 'Old Role Name']);

    Livewire::actingAs($user)
        ->test(Roles::class)
        ->set('roleId', $roleToUpdate->id)
        ->set('name', 'Updated Role Name')
        ->call('save');

    $this->assertDatabaseHas('roles', [
        'id' => $roleToUpdate->id,
        'name' => 'Updated Role Name',
    ]);
});

test('user with correct permissions can delete a role', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'delete roles']);
    $role->syncPermissions('delete roles');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $roleToDelete = Role::create(['name' => 'Role To Delete']);

    Livewire::actingAs($user)
        ->test(Roles::class)
        ->set('roleId', $roleToDelete->id)
        ->call('delete');

    $this->assertDatabaseMissing('roles', [
        'id' => $roleToDelete->id,
    ]);
});

test('user with correct permissions can delete multiple roles', function () {
    $role = Role::create(['name' => 'Admin']);
    Permission::create(['name' => 'delete roles']);
    $role->syncPermissions('delete roles');

    $user = User::factory()->create();
    $user->assignRole('Admin');

    $roles = [
        Role::create(['name' => 'Role 1']),
        Role::create(['name' => 'Role 2']),
        Role::create(['name' => 'Role 3']),
    ];

    Livewire::actingAs($user)
        ->test(Roles::class)
        ->set('selectedRoleIds', collect($roles)->pluck('id')->toArray())
        ->call('deleteSelected');

    foreach ($roles as $role) {
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
});

test('unauthorized user cannot create a role', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    Livewire::actingAs($user)->test(Roles::class)
        ->set('name', 'Unauthorized Role')
        ->call('save');

    $this->assertDatabaseMissing('roles', [
        'name' => 'Unauthorized Role',
    ]);
});

test('unauthorized user cannot update a role', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    $role = Role::create(['name' => 'Role To Update']);

    Livewire::actingAs($user)->test(Roles::class)
        ->set('roleId', $role->id)
        ->set('name', 'Updated Role Name')
        ->call('save');

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'Role To Update',
    ]);
});

test('unauthorized user cannot delete a role', function () {
    Role::create(['name' => 'User']);

    $user = User::factory()->create();
    $user->assignRole('User');

    $role = Role::create(['name' => 'Role To Delete']);

    Livewire::actingAs($user)
        ->test(Roles::class)
        ->set('roleId', $role->id)
        ->call('delete');

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
    ]);
});