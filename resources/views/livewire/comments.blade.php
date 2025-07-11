<div class="space-y-4">
    <div class="flex flex-col space-y-2">
        <x-comments.heading />

        <x-comments.form />
    </div>

    @if($this->getTotalCommentsCount())
        <x-comments.order-buttons />

        @foreach ($comments as $comment)
            <x-comments.item :comment="$comment" />
        @endforeach

        <x-likes.modal />
    @endif
</div>