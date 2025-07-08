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
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Blockable, HasComments, HasFollowers, HasLikes, HasPosts, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'date_of_birth',
        'country',
        'profile_picture',
        'password',
        'is_private',
    ];

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

    public function kanbanBoards()
    {
        return $this->belongsToMany(KanbanBoard::class, 'kanban_board_user')->withTimestamps();
    }
}
