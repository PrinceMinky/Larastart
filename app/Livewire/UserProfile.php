<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Traits\HasFollowers;
use App\Traits\WithModal;
use Illuminate\Support\Facades\Auth;

class UserProfile extends BaseComponent
{
    use WithModal, HasFollowers;

    public User $user;

    public $modalType = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)
            ->with(['posts', 'following', 'followers'])
            ->firstOrFail();
    
        if (Auth::check() && $this->user->blockedUsers()->where('blocked_user_id', Auth::id())->exists()) {
            abort(404);
        }
    
        if (Auth::check()) {
            Auth::user()->load(['following' => function($query) {
                $query->where('following_id', $this->user->id);
            }]);
        }
    }

    public function getLikedUsersProperty()
    {
        $users = User::whereIn('id', $this->post->likes->pluck('user_id'))
                    ->with(['followers' => function($query) {
                        $query->where('follower_id', auth()->id);
                    }])
                    ->get();
        
        if (Auth::check()) {
            Auth::user()->load(['following' => function($query) use ($users) {
                $query->whereIn('following_id', $users->pluck('id'));
            }]);
        }
        
        return $users;
    }

    public function showModal($type)
    {
        $this->modalType = $type;

        $this->resetAndShowModal('showModal');
    }
        
    public function render()
    {
        return view('livewire.user-profile.index');
    }
}