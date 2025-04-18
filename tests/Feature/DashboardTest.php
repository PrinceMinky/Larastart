<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get(route('dashboard'))->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('dashboard'))->assertStatus(200);
});

test('users without the permissions to view admin dashboard are thrown error 403', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertStatus(403);
});

test('users with permission to view admin dashboard can see the dashboard', function () {
    Role::create(['name' => 'Super Admin']);

    $this->actingAs($user = User::factory()->create());
    $user->assignRole('Super Admin');

    $this->get(route('admin.dashboard'))->assertStatus(200);
});
