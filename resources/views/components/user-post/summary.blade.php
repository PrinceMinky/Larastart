@if($post->likes_count >= 1)
<flux:card size="sm">
    <flux:text>
        Liked by 
        @if(auth()->user()->hasLiked($post))
            you
            @if($post->likes_count > 1)
                <span wire:click="showLikes({{ $post->id }})" class="cursor-pointer">
                    and {{ $post->likes_count - 1 }} {{ Str::plural('other', $post->likes_count - 1) }}
                </span>
            @endif
        @else
            <span wire:click="showLikes({{ $post->id }})" class="cursor-pointer">
                {{ $post->likes_count }} {{ Str::plural('other', $post->likes_count) }}
            </span>
        @endif
    </flux:text>
</flux:card>
@endif