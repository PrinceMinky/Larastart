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
    private $postsCache = null;

    // In your UserPost class
    public function mount()
    {
        $this->user = Auth::user();
        
        // Pre-cache liked posts for the authenticated user
        if (Auth::check()) {
            Auth::user()->likedPostsCache = Auth::user()->likedPosts()->pluck('post_id')->toArray();
        }
    }

    #[Computed]
    public function posts()
    {
        if ($this->postsCache !== null) {
            return $this->postsCache;
        }
        
        $query = Post::query();
        
        if ($this->userId) {
            $query->where('user_id', $this->userId);
        } else {
            $followingIds = Auth::user()->following()
                ->wherePivot('status', 'accepted')
                ->pluck('users.id');
                
            $query->where('user_id', Auth::id())
                  ->orWhereIn('user_id', $followingIds);
        }
        
        $this->postsCache = $query->with([
                'user:id,name,username',
                'likes:id,name,username,post_likes.post_id'
            ])
            ->withCount('likes')
            ->latest()
            ->get();
            
        return $this->postsCache;
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
        
        $this->postsCache = null;
        
        if (isset($user->likedPostsCache)) {
            unset($user->likedPostsCache);
        }
    }

    public function likedBy($postId)
    {
        $post = Post::findOrFail($postId);   

        $likedUsers = $post->likes()
            ->with(['followers' => function($query) {
                $query->where('follower_id', auth()->id);
            }])
            ->get();
        
        Auth::user()->load(['following' => function($query) use ($likedUsers) {
            $query->whereIn('following_id', $likedUsers->pluck('id'));
        }]);
        
        $this->likedUsers = $likedUsers;
        $this->resetAndShowModal('show-likes');
    }

    public function render()
    {
        return view('livewire.user-post.index');
    }
}
