<?php

namespace App\Models;

use App\Enums\Country;
use App\Traits\Blockable;
use App\Traits\HasComments;
use App\Traits\HasFollowers;
use App\Traits\HasLikes;
use App\Traits\HasPosts;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasPosts, Blockable, HasComments, HasFollowers, HasLikes, HasRoles, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'datetime',
            'password' => 'hashed',
            'country' => Country::class,
            'is_private' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Return url link as a string
     */
    public function url()
    {
        return route('profile.show', ['username' => $this->username]);
    }

    /**
     * Creates a URL attribute
     */
    public function getUrlAttribute()
    {
        return route('profile.show', ['username' => $this->username]);
    }

    /**
     * Creates a Display Name attribute used for links
     */
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    /**
     * Determine if authenticated user is selected user
     */
    public function me($givenId)
    {   
        return Auth::user()->id === $givenId;
    }

    /**
     * Determine if authenticated user is selected user
     */
    public function is_me()
    {   
        return Auth::user()->id === $this->id;
    }

    /**
     * Determines if user is a moderator
     */
    public function getIsModeratorAttribute()
    {
        return $this->hasRole("Moderator");
    }

    public function kanbanBoards()
    {
        return $this->belongsToMany(KanbanBoard::class, 'kanban_board_user')->withTimestamps();
    }
}
