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
        
        <flux:separator />

        <div class="flex gap-5">
            <flux:text class="flex gap-2 items-center text-xs">
                <flux:icon.hand-thumb-up size="sm" />
                <flux:link variant="subtle" clase="text-sm" class="cursor-pointer" @click="alert('Coming Soon...')">
                    Like
                </flux:link>
            </flux:text>

            <flux:text class="flex gap-2 items-center text-xs">
                <flux:icon.chat-bubble-left-ellipsis size="sm" />
                <flux:link variant="subtle" clase="text-sm" class="cursor-pointer" @click="alert('Coming Soon...')">
                    Comment
                </flux:link>
            </flux:text>
        </div>
    </flux:card>
    @endforeach
</div>