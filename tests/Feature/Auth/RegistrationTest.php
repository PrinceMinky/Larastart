<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    if (! Role::where('name', 'Super Admin')->exists()) {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
    }

    $response = Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('username', 'username')
        ->set('date_of_birth', '1988-09-03 00:00:00')
        ->set('country', 'GB')
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
