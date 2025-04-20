<?php

use App\Livewire\UserPost;
use App\Livewire\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('authenticated user is correctly identified', function () {
    $user = User::factory()->create();
    Auth::login($user);

    expect(Auth::user()->me($user->id))->toBeTrue();
});

test('non-matching user is not recognized as authenticated', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    Auth::login($user1);

    expect(Auth::user()->me($user2->id))->toBeFalse();
});

test('user with permission can view users', function () {
    Permission::create(['name' => 'view users']);

    $adminUser = User::factory()->create();
    $adminUser->givePermissionTo('view users');

    Auth::login($adminUser);

    expect(Auth::user()->can('view users'))->toBeTrue();
});

test('private user profile is not visible without permission', function () {
    $user = User::factory()->create(['is_private' => 1]);
    $otherUser = User::factory()->create();

    Auth::login($otherUser);

    $result = Auth::user()->can('view users') || (Auth::user()->me($user->id) && $user->is_private !== 1);

    expect($result)->toBeFalse();
});

test('user can access profile if conditions are met', function () {
    $user = User::factory()->create(['is_private' => 0]);
    Auth::login($user);

    $result = Auth::user()->can('view users') || (Auth::user()->me($user->id) && $user->is_private !== 1);

    expect($result)->toBeTrue();
});

test('user can post on their own profile', function () {
    $user = User::factory()->create();
    Auth::login($user);

    Livewire::actingAs($user)
        ->test(UserPost::class, ['username' => $user->username])
        ->set('status', 'Hello, this is my post!')
        ->call('post');

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'content' => 'Hello, this is my post!',
    ]);
});
