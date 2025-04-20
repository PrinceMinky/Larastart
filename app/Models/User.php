<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Country;
use App\Traits\HasPosts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasPosts, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
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
     * Determine if authenticated user is selected user
     */
    public function me($givenId)
    {   
        return Auth::user()->id === $givenId;
    }

    /**
     * Determine if authenticated user is the selected user or has a specific permission.
     * If permission is null, bypass the check.
     */
    public function hasAccessToUser($user, $permissions = null)
    {
        // Check if the user has specific permissions
        if ($permissions !== null) {
            if (is_array($permissions)) {
                foreach ($permissions as $permission) {
                    if (Auth::user()->can($permission)) {
                        return true;
                    }
                }
            } elseif (Auth::user()->can($permissions)) {
                return true;
            }
        }
    
        // Check if the user is the same or if their profile is public
        if ($this->me($user->id) || !$user->is_private) {
            return true;
        }
    
        // NEW: Check if the user follows and the request was accepted
        return $user->followers()
            ->where('follower_id', Auth::id())
            ->wherePivot('status', 'accepted')
            ->exists();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->withPivot('status');
    }
    
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
            ->withPivot('status');
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }
    
    public function follow(User $user)
    {
        if (!$this->isFollowing($user)) {
            $this->following()->attach($user->id);
        }
    }

    public function unfollow(User $user)
    {
        $this->following()->detach($user->id);
    }
}
