<div class="space-y-2">
    @if($variant === "segmented")    
        <flux:card size="sm" class="flex flex-col space-y-2">
            <x-comments.form />
        </flux:card>

        @if($this->getTotalCommentsCount())
            @foreach ($comments as $comment)
            <flux:card size="sm">
                <x-comments.item :comment="$comment" />
            </flux:card>
            @endforeach
        @endif
    @else
        <div class="flex flex-col space-y-2">
            <x-comments.heading />

            <x-comments.form />
        </div>

        @if($this->getTotalCommentsCount())
            <x-comments.order-buttons />

            @foreach ($comments as $comment)
                <x-comments.item :comment="$comment" />
            @endforeach

            @endif
        @endif
    <x-likes.modal />
</div>