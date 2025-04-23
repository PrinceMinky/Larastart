<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Country;
use App\Traits\HasPosts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

    /**
     * Determine if authenticated user is the selected user or has a specific permission.
     * If permission is null, bypass the check.
     */
    public function hasAccessToUser($user, $permissions = null)
    {
        static $accessCache = [];
    
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
    
        if ($this->me($user->id) || !$user->is_private) {
            return true;
        }
    
        $cacheKey = 'access_' . Auth::id() . '_' . $user->id;
    
        if (array_key_exists($cacheKey, $accessCache)) {
            return $accessCache[$cacheKey];
        }
    
        $accessCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $user->followers()
                ->where('follower_id', Auth::id())
                ->wherePivot('status', 'accepted')
                ->limit(1)
                ->exists();
        });
    
        return $accessCache[$cacheKey];
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
        if ($this->relationLoaded('following')) {
            return $this->following->contains('id', $user->id);
        }
        
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

    public function followRequests()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->wherePivot('status', 'pending');
    }

    public function getMutualFollowersProperty()
    {
        if (!Auth::check()) {
            return collect(); 
        }

        $profileFollowers = $this->user->followers->pluck('id');

        $authFollowers = Auth::user()->followers->pluck('id');

        $mutualFollowerIds = $profileFollowers->intersect($authFollowers);

        return User::whereIn('id', $mutualFollowerIds)->get();
    }

    public function followsMe()
    {
        return $this->following->contains(Auth::id());
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    }

    public function hasLiked($post)
    {
        $postId = $post instanceof \Illuminate\Database\Eloquent\Model ? $post->id : $post;
        
        if ($post instanceof \Illuminate\Database\Eloquent\Model && $post->relationLoaded('likes')) {
            return $post->likes->contains('id', $this->id);
        }
        
        if (!isset($this->likedPostsCache)) {
            $this->likedPostsCache = $this->likedPosts()->pluck('post_id')->toArray();
        }
        
        return in_array($postId, $this->likedPostsCache);
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id');
    }

    public function blockedByUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'blocked_user_id', 'user_id');
    }
}
