<div class="flex flex-col gap-2">
    @foreach($posts as $post)
    <flux:card wire:key="{{ $post->id }}" class="relative flex flex-col gap-2 group" size="sm">
        @if(Auth::id() === $post->user_id)
        <div class="absolute top-2 right-2">
            <flux:dropdown position="bottom" align="end">
                <flux:button icon="ellipsis-horizontal" size="sm" />
    
                <flux:menu>
                    <flux:menu.item icon="pencil" wire:click="edit({{ $post->id }})">Edit Post</flux:menu.item>
                    <flux:menu.item icon="trash" wire:confirm="Are you sure you wish to delete this post?" wire:click="deletePost({{ $post->id }})" variant="danger">Delete Post</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>
        @endif

        <div class="flex gap-2">
            <flux:avatar :name="$post->user->name" color="auto" />
            
            <div class="flex flex-col gap-0">
                <flux:heading>
                    @if(Route::currentRouteName() !== 'profile.show')
                    <flux:link wire:navigate :href="route('profile.show', ['username' => $post->user->username])" variant="ghost" class="!no-underline !hover:no-underline">
                        {{ $post->user->name }}
                    </flux:link>
                    @else
                        {{ $post->user->name }}
                    @endif
                </flux:heading>
                <flux:text>Posted on {{ $post->created_at->format('M d, Y') }}</flux:text>
            </div>
        </div>

        <flux:separator />

        @if($this->editingPostId === $post->id)
        <form wire:submit="updatePost"
            class="flex flex-col gap-2"
            @click.outside="$wire.cancelEdit()"
            >

            <flux:input
                x-data="{
                    init() {
                        // Wait a bit to ensure component is fully initialized
                        setTimeout(() => {
                            this.$el.focus();
                        }, 50);
                    }
                }"
                wire:model="editingContent"
                type="text"
                class="w-full"
                placeholder="What are you up to?"
                wire:loading.class="opacity-50"
            />

            <flux:error name="editingContent" />
            <div class="flex justify-end gap-2">
                <flux:button wire:click="cancelEdit" size="sm">Cancel</flux:button>
                <flux:button wire:click="updatePost" variant="primary" size="sm">Save</flux:button>
            </div>
        </form>
        @else
            <x-truncate-text :text="$post->content" />
        @endif

        <div class="flex justify-end gap-2">
            <flux:button
                wire:click="togglePostLike({{ $post->id }})"
                class="text-sm cursor-pointer"
                size="sm"
                icon="hand-thumb-up"
                >
                {{ auth()->user()->hasLiked($post) ? 'Unlike' : 'Like' }}
            </flux:button>

            <flux:button
                @click="alert('Coming Soon...')"
                class="text-sm cursor-pointer"
                size="sm"
                icon="chat-bubble-left-ellipsis"
                >
                Comment
            </flux:button>
        </div>

        @if($post->likes()->count() >= 1)
            <flux:card size="sm">
                <flux:text>
                    Liked by 
                    @if(auth()->user()->hasLiked($post))
                        you
                        @if($post->likes()->count() > 1)
                            <span wire:click="likedBy({{ $post->id }})" class="cursor-pointer">
                                and {{ $post->likes()->count() - 1 }} {{ Str::plural('other', $post->likes()->count() - 1) }}
                            </span>
                        @endif
                    @else
                        <span wire:click="likedBy({{ $post->id }})" class="cursor-pointer">
                            {{ $post->likes()->count() }} {{ Str::plural('other', $post->likes()->count()) }}
                        </span>
                    @endif
                </flux:text>
            </flux:card>
        @endif
    </flux:card>
    @endforeach

    <flux:modal name="show-likes" class="md:w-96">
        <flux:heading size="lg">Likes</flux:heading>
        
        <div class="flex flex-col gap-3 mt-4">
            @foreach($this->likedUsers as $like)
            <div class="flex items-center justify-between gap-2">
                <div class="flex gap-2">
                    <flux:avatar :name="$like->name" color="auto" />
                    
                    <div class="flex flex-col gap-0">
                        <flux:heading>
                            <flux:link wire:navigate :href="route('profile.show', ['username' => $like->username])" variant="ghost" class="flex gap-0 !no-underline !hover:no-underline">
                                {{ $like->name }}
                            </flux:link>
                        </flux:heading>
                        <flux:text>{{ $like->username }}</flux:text>
                    </div>
                </div>
    
                <div>
                    <x-user-profile.follow-button :user="$like" />
                </div>
            </div>
            @endforeach
        </div>
    </flux:modal>
</div>