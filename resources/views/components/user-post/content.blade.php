@if($editingPostId === $post->id)
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
    <flux:text size="lg">{!! nl2br(strip_tags($post->content)) !!}</flux:text>
@endif