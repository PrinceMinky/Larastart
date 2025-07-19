<?php

use Livewire\Livewire;
use App\Models\Badword;
use App\Livewire\Admin\BadwordManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(Tests\Traits\ActAs::class);

test('super admin can view the bad words management screen', function () {
    $this->actAsSuperAdmin();

    $this->get(route('admin.misc.badwords'))
        ->assertStatus(200)
        ->assertSee('Badwords Management');
});

test('authorised user can view bad words management screen', function () {
    $this->actAsAdmin(['view badwords']);

    $this->get(route('admin.misc.badwords'))
        ->assertStatus(200);
});

test('unauthorised user cannot view bad words management screen', function () {
    $this->actAsUser();

    $this->get(route('admin.misc.badwords'))
        ->assertForbidden();
});

test('authorised user can create a bad word', function () {
    $this->actAsAdmin(['create badwords']);

    Livewire::test(BadwordManagement::class)
        ->set('word', 'foo')
        ->set('replacement', 'bar')
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('badwords', [
        'word' => 'foo',
        'replacement' => 'bar',
    ]);
});

test('authorised user can update a bad word', function () {
    $this->actAsAdmin(['edit badwords']);

    $badword = Badword::create([
        'word' => 'foo',
        'replacement' => 'bar',
    ]);

    Livewire::test(BadwordManagement::class)
        ->call('startEditing', $badword->id, 'word', $badword->word)
        ->set('temp', 'baz')
        ->call('saveInline', \App\Models\Badword::class, $badword->id, 'word', 'edit badwords')
        ->assertHasNoErrors();

    expect($badword->fresh()->word)->toBe('baz');
    expect($badword->fresh()->replacement)->toBe('bar');
});

test('authorised user can update a replacement bad word', function () {
    $this->actAsAdmin(['edit badwords']);

    $badword = Badword::create([
        'word' => 'foo',
        'replacement' => 'bar',
    ]);

    Livewire::test(BadwordManagement::class)
        ->call('startEditing', $badword->id, 'replacement', $badword->replacement)
        ->set('temp', 'qux')
        ->call('saveInline', \App\Models\Badword::class, $badword->id, 'replacement', 'edit badwords')
        ->assertHasNoErrors();

    expect($badword->fresh()->word)->toBe('foo');
    expect($badword->fresh()->replacement)->toBe('qux');
});

test('authorised user can delete a bad word', function () {
    $this->actAsAdmin(['delete badwords']);

    $badword = Badword::create(['word' => 'foo','replacement' => 'bar']);

    Livewire::test(BadwordManagement::class)
        ->call('showConfirmDeleteForm', $badword->id)
        ->call('delete')
        ->assertHasNoErrors();

    expect(Badword::find($badword->id))->toBeNull();
});