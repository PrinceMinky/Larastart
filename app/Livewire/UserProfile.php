<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Models\Post;

class UserProfile extends BaseComponent
{
    public User $user;
    public $status = '';

    public function mount($username) 
    {
        $this->user = User::whereUsername($username)->with('posts')->first();
    }

    public function post()
    {
        $this->validate([
            'status' => 'required|min:3'
        ]);

        auth()->user()->posts()->create([
            'content' => $this->status
        ]);

        $this->reset('status');

        $this->toast([
            'text' => 'Status updated!',
            'variant' => 'success'
        ]);
    }

    public function deletePost($postId)
    {
        $this->authorize('delete posts');
    
        $post = auth()->user()->posts()->whereId($postId)->firstOrFail(); 
        $post->delete(); 
        
        $this->toast([
            'text' => 'Status deleted!',
            'variant' => 'danger'
        ]);
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
