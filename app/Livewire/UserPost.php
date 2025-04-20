<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use App\Livewire\BaseComponent;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPost extends BaseComponent
{
    public User $user;
    public $status = '';
    public $userId = null;
    public $editingPostId = null;
    public $editingContent = '';

    public function mount()
    {
        $this->user = Auth::user();
    }

    #[Computed]
    public function posts()
    {
        if ($this->userId) {
            return Post::where('user_id', $this->userId)
                ->with('user')
                ->latest()
                ->get();
        }
        
        $followingIds = Auth::user()->following()
            ->wherePivot('status', 'accepted')
            ->pluck('users.id'); 

        return Post::where('user_id', Auth::id()) 
            ->orWhereIn('user_id', $followingIds) 
            ->with('user')
            ->latest() 
            ->get();
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

    public function edit($postId)
    {
        $post = Post::find($postId);
        
        if ($post && $post->user_id === Auth::id()) {
            $this->editingPostId = $postId;
            $this->editingContent = $post->content;
        }
    }
    
    public function cancelEdit()
    {
        $this->editingPostId = null;
        $this->editingContent = '';
    }
    
    public function updatePost()
    {
        $this->validate([
            'editingContent' => 'required|min:3'
        ]);
        
        $post = Post::where('id', $this->editingPostId)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($post) {
            $post->update([
                'content' => $this->editingContent
            ]);
            
            $this->toast([
                'text' => 'Post updated!',
                'variant' => 'success'
            ]);
        }
        
        $this->editingPostId = null;
        $this->editingContent = '';
    }

    public function deletePost($postId)
    {
        $post = Auth::user()->posts()->whereId($postId)->firstOrFail();
        $post->delete();
        
        $this->toast([
            'text' => 'Status deleted!',
            'variant' => 'danger'
        ]);
    }

    public function render()
    {
        return view('livewire.user-post.index');
    }
}
