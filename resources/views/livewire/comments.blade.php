<div class="space-y-4">
    <div class="flex flex-col space-y-2">
        <flux:heading size="lg">
            Comments

            @if($this->getTotalCommentsCount())
                ({{ $this->getTotalCommentsCount() }})
            @endif
        </flux:heading>

        <flux:textarea
            wire:model.defer="storeCommentForm.body"
            class="w-full border rounded p-2"
            placeholder="Write a comment..."
        />
        <flux:error name="storeCommentForm.body" />

        <div class="flex justify-end">
            <flux:button wire:click="postComment">Post</flux:button>
        </div>
    </div>

    @if($this->getTotalCommentsCount())
    <div>
        <flux:radio.group wire:model.live="orderBy" variant="buttons">
            <flux:radio size="sm" value="top">Top</flux:radio>        {{-- most‑liked --}}
            <flux:radio size="sm" value="newest">Newest</flux:radio>  {{-- latest --}}
        </flux:radio.group>
    </div>

    @foreach ($comments as $comment)
        <x-comments.item :comment="$comment" />
    @endforeach

    <x-likes.modal />
    @endif
</div>
