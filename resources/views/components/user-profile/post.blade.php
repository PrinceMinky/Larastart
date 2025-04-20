<div>
    <flux:card wire:key="{{ $post->id }}" class="relative flex flex-col gap-2 group" size="sm">
        <div class="absolute top-2 right-2">
            <flux:dropdown position="bottom" align="end">
                <flux:button icon="ellipsis-horizontal" size="sm" />
    
                <flux:menu>
                    <flux:menu.item icon="trash" wire:confirm="Are you sure you wish to delete this post?" wire:click="deletePost({{ $post->id }})" variant="danger">Delete Post</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>

        <div class="flex gap-2">
            <flux:avatar :name="$post->user->name" color="auto" />
            
            <div class="flex flex-col gap-0">
                <flux:heading>{{ $post->user->name }}</flux:heading>
                <flux:text>Posted on {{ $post->created_at->format('M d, Y') }}</flux:text>
            </div>
        </div>

        <flux:separator />

        <flux:text>{{ $post->content }}</flux:text>
        
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
</div>