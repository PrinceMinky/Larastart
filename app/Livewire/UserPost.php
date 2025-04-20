<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use App\Livewire\BaseComponent;
use App\Models\Post;
use App\Models\User;
use App\Traits\HasFollowers;
use App\Traits\WithModal;
use Illuminate\Support\Facades\Auth;

class UserPost extends BaseComponent
{
    use WithModal, HasFollowers;

    public User $user;
    public $status = '';
    public $userId = null;
    public $editingPostId = null;
    public $editingContent = '';
    public $likedUsers = [];

    public function mount()
    {
        $this->user = Auth::user();
    }

    #[Computed]
    public function posts()
    {
        if ($this->userId) {
            return Post::where('user_id', $this->userId)
                ->with(['user', 'likes'])
                ->latest()
                ->get();
        }
        
        $followingIds = Auth::user()->following()
            ->wherePivot('status', 'accepted')
            ->pluck('users.id');
    
        return Post::where('user_id', Auth::id()) 
            ->orWhereIn('user_id', $followingIds) 
            ->with(['user', 'likes'])
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

    public function togglePostLike($postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user();

        if ($user->hasLiked($post)) {
            $user->likedPosts()->detach($post->id);
        } else {
            $user->likedPosts()->attach($post->id);
        }
    }

    public function likedBy($postId)
    {
        $this->likedUsers = Post::find($postId)->likes()->get();

        $this->resetAndShowModal('show-likes');
    }

    public function render()
    {
        return view('livewire.user-post.index');
    }
}
