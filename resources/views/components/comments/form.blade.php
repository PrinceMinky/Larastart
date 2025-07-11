<flux:textarea
    wire:model.defer="storeCommentForm.body"
    class="w-full border rounded p-2"
    placeholder="Write a comment..."
/>
<flux:error name="storeCommentForm.body" />

<div class="flex justify-end">
    <flux:button wire:click="postComment">Post</flux:button>
</div>