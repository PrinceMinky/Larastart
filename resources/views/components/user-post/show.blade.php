<div class="flex flex-col gap-2">
    @foreach($posts as $post)
        <x-user-post.card :$post />
    @endforeach

    <x-user-post.likes-modal :likedUsers="$this->likedUsers" />
</div>