<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\UserPost;
use App\Livewire\BlockUser;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\UserProfile;

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

test('blocking a user unfollows them', function () {
    $authUser = User::factory()->create();
    $blockedUser = User::factory()->create();

    // Simulate following before blocking
    $authUser->following()->attach($blockedUser->id);
    $blockedUser->following()->attach($authUser->id);

    // Act: Block the user
    Livewire::actingAs($authUser)
        ->test(UserProfile::class, ['username' => $blockedUser->username])
        ->call('toggleBlock');

    // Assert: Check that follow relationships were removed
    $this->assertDatabaseMissing('followers', [
        'user_id' => $authUser->id,
        'following_id' => $blockedUser->id,
    ]);

    $this->assertDatabaseMissing('followers', [
        'user_id' => $blockedUser->id,
        'following_id' => $authUser->id,
    ]);
});

test('unblocking a user does not restore follow relationships', function () {
    $authUser = User::factory()->create();
    $blockedUser = User::factory()->create();

    // Simulate following before blocking
    $authUser->following()->attach($blockedUser->id);
    $blockedUser->following()->attach($authUser->id);

    // Act: Block the user
    Livewire::actingAs($authUser)
        ->test(UserProfile::class, ['username' => $blockedUser->username])
        ->call('toggleBlock');

    // Act: Unblock the user
    Livewire::actingAs($authUser)
        ->test(UserProfile::class, ['username' => $blockedUser->username])
        ->call('toggleBlock');

    // Assert: Ensure follow relationships were not restored
    $this->assertDatabaseMissing('followers', [
        'user_id' => $authUser->id,
        'following_id' => $blockedUser->id,
    ]);

    $this->assertDatabaseMissing('followers', [
        'user_id' => $blockedUser->id,
        'following_id' => $authUser->id,
    ]);
});

test('blocked user is redirected when accessing a profile', function () {
    $authUser = User::factory()->create();
    $blockedUser = User::factory()->create();
    
    $authUser->blockedUsers()->attach($blockedUser->id);

    Auth::login($blockedUser);

    $this->get(route('profile.show', ['username' => $authUser->username]))
        ->assertRedirect(route('error.404'));
});

test('unblocked user can view the profile', function () {
    $user = User::factory()->create();
    $viewer = User::factory()->create();

    Auth::login($viewer);

    $this->get(route('profile.show', ['username' => $user->username]))
        ->assertOk();
});