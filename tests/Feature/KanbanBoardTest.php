<?php

use Livewire\Livewire;
use App\Models\User;
use App\Models\KanbanCard;
use App\Models\KanbanBoard;
use App\Models\KanbanColumn;

use App\Livewire\Admin\Kanban\Index as KanbanBoardsList;
use App\Livewire\Admin\Kanban\Show as KanbanBoardShow;

uses(Tests\Traits\ActAs::class);

test('kanban boards page renders', function () {
    $this->actAsSuperAdmin();

    $response = $this->get(route('admin.kanban_list'));
    $response->assertStatus(200);
});

test('creates a new kanban board', function () {
    $this->actAsSuperAdmin();

    Livewire::test(KanbanBoardsList::class)
        ->set('form.title', 'My New Board')
        ->set('form.badges', [
            ['title' => 'Urgent', 'color' => 'red'],
            ['title' => 'Review', 'color' => 'blue'],
        ])
        ->call('save')
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
        ->set('form.boardId', $board->id)
        ->set('form.title', 'Updated Title')
        ->set('form.badges', [['title' => 'NewBadge', 'color' => 'green']])
        ->call('save', $board->id)
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
        ->set('form.boardId', $board->id)
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
        ->set('selectedBoardIds', $selectedIds)
        ->call('deleteSelected')
        ->assertHasNoErrors()
        ->assertSet('selectedBoardIds', []);

    foreach ($selectedIds as $id) {
        $this->assertDatabaseMissing('kanban_boards', ['id' => $id]);
    }
});

test('board title shows locked tooltip when user cannot view board', function () {
    $user = $this->actAsAdmin();

    $board = KanbanBoard::factory()->create();

    Livewire::test(KanbanBoardsList::class)
        ->set('form.boardId', $board->id)
        ->assertDontSeeHtml('href="' . route('admin.kanban_board', ['id' => $board->id]) . '"')
        ->assertSeeHtml('You are not authorised to view this board.')
        ->assertSee($board->title);
});

test('board title shows link when user can view board', function () {
    $user = $this->actAsAdmin(['view kanban boards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    Livewire::test(KanbanBoardsList::class)
        ->set('form.boardId', $board->id)
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
        ->set('columnForm.title', 'To Do')
        ->call('saveColumn')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('kanban_columns', [
        'title' => 'To Do',
        'board_id' => $board->id,
    ]);
});

test('authorised user can edit a column', function () {
    $user = $this->actAsAdmin(['update kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('columnForm.id', $column->id)
        ->set('columnForm.title', 'Updated Column Title')
        ->call('saveColumn')
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
        ->set('columnForm.id', $column->id)
        ->call('deleteColumn')
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('kanban_columns', [
        'id' => $column->id,
    ]);
});

test('authorised user can reorder columns', function () {
    $user = $this->actAsAdmin(['edit kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    $column1 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 0]);
    $column2 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 1]);
    $column3 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 2]);

    $component = Livewire::test(KanbanBoardShow::class, ['id' => $board->id]);

    // Move column1 (currently at position 0) to position 2 (last position)
    $component->call('updateColumnPosition', $column1->id, 2)->assertHasNoErrors();

    $column1->refresh();
    $column2->refresh();
    $column3->refresh();

    // After moving column1 to position 2:
    // - column2 shifts from position 1 to 0
    // - column3 shifts from position 2 to 1  
    // - column1 moves from position 0 to 2
    expect($column1->position)->toBe(2);
    expect($column2->position)->toBe(0);
    expect($column3->position)->toBe(1);

    // Move column3 (currently at position 1) to position 0 (first position)
    $component->call('updateColumnPosition', $column3->id, 0)->assertHasNoErrors();

    $column1->refresh();
    $column2->refresh();
    $column3->refresh();

    // After moving column3 to position 0:
    // - column3 moves from position 1 to 0
    // - column2 shifts from position 0 to 1
    // - column1 stays at position 2
    expect($column1->position)->toBe(2);
    expect($column2->position)->toBe(1);
    expect($column3->position)->toBe(0);
});

// Additional test to verify edge cases
test('column position updates handle edge cases correctly', function () {
    $user = $this->actAsAdmin(['edit kanban columns']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);

    $column1 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 0]);
    $column2 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 1]);
    $column3 = KanbanColumn::factory()->create(['board_id' => $board->id, 'position' => 2]);

    $component = Livewire::test(KanbanBoardShow::class, ['id' => $board->id]);

    // Test moving to same position (should not change anything)
    $component->call('updateColumnPosition', $column2->id, 1)->assertHasNoErrors();

    $column1->refresh();
    $column2->refresh();
    $column3->refresh();

    expect($column1->position)->toBe(0);
    expect($column2->position)->toBe(1);
    expect($column3->position)->toBe(2);

    // Test moving to position beyond array bounds (should move to last position)
    $component->call('updateColumnPosition', $column1->id, 10)->assertHasNoErrors();

    $column1->refresh();
    $column2->refresh();
    $column3->refresh();

    expect($column1->position)->toBe(2);
    expect($column2->position)->toBe(0);
    expect($column3->position)->toBe(1);
});

test('authorised user can create a card', function () {
    $user = $this->actAsAdmin(['create kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->set('cardForm.column_id', $column->id)
        ->set('cardForm.title', 'New Task')
        ->set('cardForm.description', 'Task description')
        ->call('saveCard')
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
        ->set('cardForm.id', $card->id)
        ->set('cardForm.title', 'Updated Title')
        ->set('cardForm.description', 'Updated description')
        ->set('cardForm.column_id', $column->id)
        ->call('saveCard', $card->id)
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
        ->set('cardForm.id', $card->id)
        ->call('deleteCard')
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('kanban_cards', ['id' => $card->id]);
});

test('authorised user can reorder a card within the same column', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    // Create multiple cards in the same column to test reordering
    $card1 = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 0]);
    $card2 = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 1]);
    $card3 = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 2]);

    // Move card1 (position 0) to position 2 (last position)
    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card1->id, 2, $column->id)
        ->assertHasNoErrors();

    // Refresh models to get updated positions
    $card1->refresh();
    $card2->refresh();
    $card3->refresh();

    // After moving card1 to position 2:
    // - card2 shifts from position 1 to 0
    // - card3 shifts from position 2 to 1
    // - card1 moves from position 0 to 2
    expect($card1->position)->toBe(2);
    expect($card2->position)->toBe(0);
    expect($card3->position)->toBe(1);
    expect($card1->column_id)->toBe($column->id);
});

test('authorised user can move a card to the same position within the same column', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);

    $card1 = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 0]);
    $card2 = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 1]);

    // Move card2 to its current position (should not change anything)
    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card2->id, 1, $column->id)
        ->assertHasNoErrors();

    $card1->refresh();
    $card2->refresh();

    expect($card1->position)->toBe(0);
    expect($card2->position)->toBe(1);
});

test('authorised user can move a card to another column', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column1 = KanbanColumn::factory()->create(['board_id' => $board->id]);
    $column2 = KanbanColumn::factory()->create(['board_id' => $board->id]);

    // Create cards in both columns
    $card1 = KanbanCard::factory()->create(['column_id' => $column1->id, 'position' => 0]);
    $card2 = KanbanCard::factory()->create(['column_id' => $column1->id, 'position' => 1]);
    $card3 = KanbanCard::factory()->create(['column_id' => $column2->id, 'position' => 0]);
    $card4 = KanbanCard::factory()->create(['column_id' => $column2->id, 'position' => 1]);

    // Move card2 from column1 to column2 at position 1
    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card2->id, 1, $column2->id)
        ->assertHasNoErrors();

    // Refresh all cards
    $card1->refresh();
    $card2->refresh();
    $card3->refresh();
    $card4->refresh();

    // card2 should now be in column2
    expect($card2->column_id)->toBe($column2->id);
    expect($card2->position)->toBe(1);
    
    // card1 should remain in column1 but possibly reposition
    expect($card1->column_id)->toBe($column1->id);
    expect($card1->position)->toBe(0);
    
    // Cards in column2 should be reordered
    expect($card3->position)->toBe(0);
    expect($card4->position)->toBe(2); // Shifted down because card2 was inserted at position 1
});

test('authorised user can move a card to an empty column', function () {
    $user = $this->actAsAdmin(['edit kanban cards']);
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column1 = KanbanColumn::factory()->create(['board_id' => $board->id]);
    $column2 = KanbanColumn::factory()->create(['board_id' => $board->id]);

    // Create cards only in column1
    $card1 = KanbanCard::factory()->create(['column_id' => $column1->id, 'position' => 0]);
    $card2 = KanbanCard::factory()->create(['column_id' => $column1->id, 'position' => 1]);

    // Move card1 to empty column2
    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card1->id, 0, $column2->id)
        ->assertHasNoErrors();

    $card1->refresh();
    $card2->refresh();

    // card1 should now be in column2 at position 0
    expect($card1->column_id)->toBe($column2->id);
    expect($card1->position)->toBe(0);
    
    // card2 should remain in column1 and reposition to 0
    expect($card2->column_id)->toBe($column1->id);
    expect($card2->position)->toBe(0);
});

test('unauthorised user cannot reorder cards', function () {
    $user = $this->actAsAdmin([]); // No permission
    $board = KanbanBoard::factory()->create(['owner_id' => $user->id]);
    $column = KanbanColumn::factory()->create(['board_id' => $board->id]);
    $card = KanbanCard::factory()->create(['column_id' => $column->id, 'position' => 0]);

    Livewire::test(KanbanBoardShow::class, ['id' => $board->id])
        ->call('updateCardPosition', $card->id, 1, $column->id)
        ->assertForbidden();
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
