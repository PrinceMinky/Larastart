<?php

namespace App\Livewire;

use App\Events\PostLiked;
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
    public $likesSearch = '';
    private $postsCache = null;

    public function mount()
    {
        $this->user = Auth::user();
        
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
                'likes:id,name,username,post_like.post_id'
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
            
            broadcast(new PostLiked($post, $user))->toOthers();
        }
        
        $this->postsCache = null;
        
        if (isset($user->likedPostsCache)) {
            unset($user->likedPostsCache);
        }
    }

    public function likedBy($postId)
    {
        $post = Post::findOrFail($postId);   
        $authUserId = Auth::id();
    
        // Get likes with created_at timestamp and order by newest first
        $likedUsers = $post->likes()
            ->with(['followers' => function($query) use ($authUserId) {
                $query->where('follower_id', $authUserId);
            }])
            ->orderBy('post_like.created_at', 'desc')
            ->get();
        
        Auth::user()->load(['following' => function($query) use ($likedUsers) {
            $query->whereIn('following_id', $likedUsers->pluck('id'));
        }]);
        
        // Move authenticated user to the top if present in likes
        $authUserIndex = $likedUsers->search(function($item) use ($authUserId) {
            return $item->id === $authUserId;
        });
        
        if ($authUserIndex !== false) {
            $authUser = $likedUsers->pull($authUserIndex);
            $likedUsers->prepend($authUser);
        }
        
        $this->likedUsers = $likedUsers;
        $this->likesSearch = ''; // Reset search when opening modal
        $this->resetAndShowModal('show-likes');
    }
    
    public function getFilteredLikedUsers()
    {
        if (empty($this->likesSearch)) {
            return $this->likedUsers;
        }
        
        $searchTerm = strtolower($this->likesSearch);
        $authUserId = Auth::id();
        
        // Filter the users but maintain the ordering rules
        $filteredUsers = collect($this->likedUsers)->filter(function ($user) use ($searchTerm) {
            return str_contains(strtolower($user->name), $searchTerm) || 
                   str_contains(strtolower($user->username), $searchTerm);
        });
        
        // Ensure auth user stays at top if present in filtered results
        $authUserIndex = $filteredUsers->search(function($item) use ($authUserId) {
            return $item->id === $authUserId;
        });
        
        if ($authUserIndex !== false && $authUserIndex > 0) {
            $authUser = $filteredUsers->pull($authUserIndex);
            $filteredUsers->prepend($authUser);
        }
        
        return $filteredUsers;
    }

    public function render()
    {
        return view('livewire.user-post.index');
    }
}
