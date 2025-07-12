<?php

namespace App\Livewire;

use App\Livewire\BaseComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseComponent
{
    public User $user;

    public function mount()
    {
        $this->getPendingFollowersCount();
    }

    public function getPendingFollowersCount()
    {
        $this->user = Auth::user()->loadCount([
            'followers' => fn ($q) => $q->where('status', 'pending')
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
