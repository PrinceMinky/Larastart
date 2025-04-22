<flux:card wire:key="{{ $post->id }}" class="relative flex flex-col gap-2 group" size="sm">
    <x-user-post.actions :$post />

    <x-user-post.header :$post />

    <x-user-post.content :post="$post" :editingPostId="$this->editingPostId" />

    <x-user-post.interactions :post="$post" />

    <x-user-post.summary :post="$post" />
</flux:card>