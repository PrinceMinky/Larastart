<?php

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\UserManagement\Permissions;
use App\Livewire\Admin\UserManagement\Roles;
use App\Livewire\Admin\UserManagement\UserList;
use App\Livewire\Dashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('home');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard')->can('view admin dashboard');

        // User Management
        Route::get('user-management', UserList::class)->name('user.index')->can('view user management');
        Route::get('user-management/roles', Roles::class)->name('user.role')->can('view roles management');
        Route::get('user-management/permissions', Permissions::class)->name('user.permission')->can('view permissions management');
    });
});

require __DIR__.'/auth.php';
