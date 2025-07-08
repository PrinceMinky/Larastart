<div class="flex justify-end gap-2">
    <flux:button
        wire:click="like({{ $post->id }})"
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