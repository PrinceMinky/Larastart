<div class="flex flex-col gap-2">
    @forelse($posts as $post)
        <x-user-post.card :$post />
    @empty
        <flux:text>No posts created.</flux:text>
    @endforelse

    <x-likes.modal />
</div>