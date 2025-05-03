<?php

use App\Livewire\UserProfile;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('a user can visit another user\'s profile and follow them', function () {
    // Create two users
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Simulate user1 visiting user2's profile
    $this->actingAs($user1)
        ->get(route('profile.show', ['username' => $user2->username]))
        ->assertStatus(200);

    // Simulate clicking the Follow button
    Livewire::actingAs($user1)->test(UserProfile::class, ['username' => $user2->username])
        ->call('follow', $user2->id);

    // Assert that the follow relationship exists
    $this->assertDatabaseHas('follows', [
        'follower_id' => $user1->id,
        'following_id' => $user2->id,
    ]);
});

test('a user can request to follow a private profile and see "Cancel Request"', function () {
    // Create two users
    $user1 = User::factory()->create();
    $user2 = User::factory()->create(['is_private' => true]); // Private account

    // Simulate user1 visiting user2's profile
    $this->actingAs($user1)
        ->get(route('profile.show', ['username' => $user2->username]))
        ->assertStatus(200);

    // Simulate clicking the Follow button
    Livewire::actingAs($user1)->test(UserProfile::class, ['username' => $user2->username])
        ->call('follow', $user2->id);

    // Ensure follow request is pending in the database
    $this->assertDatabaseHas('follows', [
        'follower_id' => $user1->id,
        'following_id' => $user2->id,
        'status' => 'pending', // Since the profile is private
    ]);

    // Ensure the button text updates to "Cancel Request"
    Livewire::actingAs($user1)->test(UserProfile::class, ['username' => $user2->username])
        ->assertSee('Cancel Request');
});

test('a user cannot follow themselves', function () {
    // Create a user
    $user = User::factory()->create();

    // Simulate user visiting their own profile
    $this->actingAs($user)
        ->get(route('profile.show', ['username' => $user->username]))
        ->assertStatus(200);

    // Try to follow themselves
    Livewire::actingAs($user)->test(UserProfile::class, ['username' => $user->username])
        ->call('follow', $user->id);

    // Assert that the follow relationship does NOT exist
    $this->assertDatabaseMissing('follows', [
        'follower_id' => $user->id,
        'following_id' => $user->id,
    ]);
});