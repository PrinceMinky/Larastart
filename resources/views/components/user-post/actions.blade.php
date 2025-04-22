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