<?php

use Livewire\Livewire;
use App\Models\User;
use App\Models\KanbanCard;
use App\Models\KanbanBoard;
use App\Models\KanbanColumn;

use App\Livewire\Admin\KanbanBoards\Index as KanbanBoardsList;
use App\Livewire\Admin\KanbanBoards\Show as KanbanBoardShow;

uses(Tests\Traits\ActAs::class);

test('kanban boards page renders', function () {
    $this->actAsSuperAdmin();

    $response = $this->get(route('admin.kanban_list'));
    $response->assertStatus(200);
});

test('creates a new kanban board', function () {
    $this->actAsSuperAdmin();

    Livewire::test(KanbanBoardsList::class)
        ->set('title', 'My New Board')
        ->set('badges', [
            ['title' => 'Urgent', 'color' => 'red'],
            ['title' => 'Review', 'color' => 'blue'],
        ])
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_boards', [
        'title' => 'My New Board'
    ]);
});

test('edits an existing kanban board', function () {
    $this->actAsSuperAdmin();

    $board = KanbanBoard::factory()->create([
        'title' => 'Old Title',
        'badges' => [['title' => 'OldBadge', 'color' => 'gray']],
    ]);

    Livewire::test(KanbanBoardsList::class)
        ->set('boardId', $board->id)
        ->set('title', 'Updated Title')
        ->set('badges', [['title' => 'NewBadge', 'color' => 'green']])
        ->call('update', $board->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_boards', [
        'id' => $board->id,
        'title' => 'Updated Title',
    ]);
});

test('deletes a kanban board', function () {
    $this->actAsSuperAdmin();

    $board = KanbanBoard::factory()->create();

    Livewire::test(KanbanBoardsList::class)
        ->set('boardId', $board->id)
        ->call('delete')
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('kanban_boards', [
        'id' => $board->id,
    ]);
});

test('deletes multiple kanban boards', function () {
    $this->actAsSuperAdmin();

    $boards = KanbanBoard::factory()->count(3)->create();
    $selectedIds = $boards->pluck('id')->toArray();

    Livewire::test(KanbanBoardsList::class)
        ->set('selectedUserIds', $selectedIds)
        ->call('deleteSelected')
        ->assertHasNoErrors()
        ->assertSet('selectedUserIds', []);

    foreach ($selectedIds as $id) {
        $this->assertDatabaseMissing('kanban_boards', ['id' => $id]);
    }
});

test('board title shows locked tooltip when user cannot view board', function () {
    $user = $this->actAsAdmin();

    $board = KanbanBoard::factory()->create();

    Livewire::test(KanbanBoardsList::class)
        ->set('boardId', $board->id)
        ->call('loadData', $board->id)
        ->assertDontSeeHtml('href="' . route('admin.kanban_board', ['id' => $board->id]) . '"')
        ->assertSeeHtml('You are not authorised to view this board.')
        ->assertSee($board->title);
});

test('board title shows link when user can view board', function () {
    $user = $this->actAsAdmin(['view kanban boards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    Livewire::test(KanbanBoardsList::class)
        ->set('boardId', $board->id)
        ->call('loadData', $board->id)
        ->assertSeeHtml('href="' . route('admin.kanban_board', ['id' => $board->id]) . '"')
        ->assertSee($board->title)
        ->assertDontSee('You are not authorised to view this board.');
});

test('board owner can view kanban board', function () {
    $user = $this->actAsAdmin(['view kanban boards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    $response = $this->get(route('admin.kanban_board', ['id' => $board->id]));

    $response->assertStatus(200);
    $response->assertSee($board->title);
});

test('authorised team member can view kanban board', function () {
    $user = $this->actAsAdmin(['view kanban boards']);
    $board = KanbanBoard::factory()->create();

    $board->users()->attach($user);

    $response = $this->get(route('admin.kanban_board', ['id' => $board->id]));

    $response->assertStatus(200);
    $response->assertSee($board->title);
});

test('user with permission to view boards but not owner or team member cannot view kanban board', function () {
    $user = $this->actAsAdmin(['view kanban boards']);
    $board = KanbanBoard::factory()->create();

    $response = $this->get(route('admin.kanban_board', ['id' => $board->id]));

    $response->assertForbidden();
});

test('authorised user can create a column', function () {
    $user = $this->actAsAdmin(['create kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('columnTitle', 'To Do')
        ->call('createColumn')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_columns', [
        'title' => 'To Do',
        'board_id' => $board->id,
    ]);
});

test('authorised user can edit a column', function () {
    $user = $this->actAsAdmin(['edit kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('columnId', $column->id)
        ->set('columnTitle', 'Updated Column Title')
        ->call('updateColumn')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_columns', [
        'id' => $column->id,
        'title' => 'Updated Column Title',
    ]);
});

test('authorised user can delete a column', function () {
    $user = $this->actAsAdmin(['delete kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('columnId', $column->id)
        ->call('deleteColumn')
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('kanban_columns', [
        'id' => $column->id,
    ]);
});

test('authorised user can reorder columns', function () {
    $user = $this->actAsAdmin(['edit kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    $column1 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 1]);
    $column2 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 2]);
    $column3 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 3]);

    $component = Livewire::test(KanbanBoardShow::class, ['id' => $board->id]);

    $component->call('updateColumnPosition', $column1->id, 3)->assertHasNoErrors();

    $column1->refresh();
    $column2->refresh();
    $column3->refresh();

    expect($column1->position)->toBe(3);
    expect($column2->position)->toBe(1);
    expect($column3->position)->toBe(2);

    $component->call('updateColumnPosition', $column3->id, 1)->assertHasNoErrors();

    $column1->refresh();
    $column2->refresh();
    $column3->refresh();

    expect($column1->position)->toBe(3);
    expect($column2->position)->toBe(2);
    expect($column3->position)->toBe(1);
});

test('authorised user can create a card', function () {
    $user = $this->actAsAdmin(['create kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('columnId', $column->id)
        ->set('cardTitle', 'New Task')
        ->set('cardDescription', 'Task description')
        ->call('createCard')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_cards', [
        'title' => 'New Task',
        'description' => 'Task description',
        'column_id' => $column->id,
    ]);
});

test('authorised user can edit a card', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);
    $card = KanbanCard::factory()->create([
        'column_id' => $column->id,
        'title' => 'Old Title',
        'description' => 'Old description',
    ]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('cardId', $card->id)
        ->set('cardTitle', 'Updated Title')
        ->set('cardDescription', 'Updated description')
        ->set('columnId', $column->id)
        ->call('updateCard', $card->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_cards', [
        'id' => $card->id,
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'column_id' => $column->id,
    ]);
});

test('authorised user can delete a card', function () {
    $user = $this->actAsAdmin(['delete kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);
    $card = KanbanCard::factory()->create(['column_id' => $column->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('cardId', $card->id)
        ->call('deleteCard')
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('kanban_cards', ['id' => $card->id]);
});

test('authorised user can reorder a card within the same column', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    $card = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 1]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card->id, 1, $column->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_cards', [
        'id' => $card->id,
        'position' => 1,
        'column_id' => $column->id,
    ]);
});

test('authorised user can reorder a card into another column', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column1 = KanbanColumn::factory()->create(['board_id' => $board->id]);
    $column2 = KanbanColumn::factory()->create(['board_id' => $board->id]);

    $card = KanbanCard::factory()->create(['column_id' => $column1->id, 'position' => 1]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card->id, 1, $column2->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_cards', [
        'id' => $card->id,
        'position' => 1,
        'column_id' => $column2->id,
    ]);
});

test('authorised user can associate users to the board', function () {
    $adminUser = $this->actAsAdmin(['manage kanban users']);
    $board = KanbanBoard::factory()->create(['owner_id' => $adminUser->id]);

    $usersToAssociate = User::factory()->count(3)->create();

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('selectedUserIds', $usersToAssociate->pluck('id')->toArray())
        ->call('associateUsers')
        ->assertHasNoErrors();

    $board->refresh();
    foreach ($usersToAssociate as $user) {
        $this->assertTrue($board->users->contains($user));
    }
});

test('authorised user can remove a user from the board', function () {
    $adminUser = $this->actAsAdmin(['manage kanban users']);
    $board = KanbanBoard::factory()->create(['owner_id' => $adminUser->id]);

    $user = User::factory()->create();
    $board->users()->attach($user->id);

    $this->assertTrue($board->users->contains($user));

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('removeUser', $user->id)
        ->assertHasNoErrors();

    $board->refresh();
    $this->assertFalse($board->users->contains($user));
});
