<?php

use App\Livewire\UserSearch;

use App\Livewire\Admin\KanbanBoards\Index as KanbanBoardsList;
use App\Livewire\Admin\KanbanBoards\Show as KanbanBoardShow;
use App\Livewire\Admin\KanbanBoards\Card as KanbanBoardCard;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\UserManagement\Permissions;
use App\Livewire\Admin\UserManagement\Roles;
use App\Livewire\Admin\UserManagement\UserList;
use App\Livewire\Dashboard;
use App\Livewire\FollowRequests;
use App\Livewire\Notifications;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Privacy;
use App\Livewire\Settings\Profile;
use App\Livewire\UserProfile;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('follow-requests', FollowRequests::class)->name('follow.requests');
    Route::get('notifications', Notifications::class)->name('notifications.index');
    Route::get('notifications/{id}', null)->name('notifications.show');

    Route::get('users', UserSearch::class)->name('users.list');
    Route::get('profile/{username}', UserProfile::class)->name('profile.show');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/privacy', Privacy::class)->name('settings.privacy');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard')->can('view admin dashboard');
    
        Route::get('kanban-boards', KanbanBoardsList::class)->name('kanban_list')->can('view kanban boards');
        Route::get('kanban-board/{id}', KanbanBoardShow::class)->name('kanban_board')->can('view kanban boards');
        Route::get('kanban-board/{board_id}/{column_id}/{card_id}', KanbanBoardCard::class)->name('kanban_board_card')->can('view kanban boards');

        // User Management
        Route::get('user-management', UserList::class)->name('user.index')->can('view users');
        Route::get('user-management/roles', Roles::class)->name('user.role')->can('view roles');
        Route::get('user-management/permissions', Permissions::class)->name('user.permission')->can('view permissions');
    });
});

// Custom Error Pages
Route::view('/error/404', 'errors.404')->name('error.404');

require __DIR__.'/auth.php';
