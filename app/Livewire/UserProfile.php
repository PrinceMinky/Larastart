<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class UserProfile extends BaseComponent
{
    public User $user;
    public $status = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)->with('posts')->first();
    }
    
    #[Computed]
    public function posts()
    {
        return Post::with('user')->whereUserId($this->user->id)->latest()->get();
    }
    
    public function post()
    {
        if (! Auth::user()->me($this->user->id)) {
            abort(403, 'You are not authorized to post on this profile.');
        }
        
        $this->validate([
            'status' => 'required|min:3'
        ]);
        
        Auth::user()->posts()->create([
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
        
        $post = Auth::user()->posts()->whereId($postId)->firstOrFail();
        $post->delete();
        
        $this->toast([
            'text' => 'Status deleted!',
            'variant' => 'danger'
        ]);
    }
    
    public function render()
    {
        return view('livewire.user-profile.index');
    }
}