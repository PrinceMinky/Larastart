<section class="flex flex-col gap-2">
    <!-- Heading -->
    <x-page-heading>
        <x-slot name="heading">Comments Management</x-slot>
        <x-slot name="subheading">This is a comment posted by {{ $comment->user->name }}.</x-slot>
    </x-page-heading>

    <!-- Display breadcrumbs -->

    <!-- Show comment -->
    <flux:heading size="lg">
        Comment
    </flux:heading>

    <flux:card size="sm">
        <flux:text>
            <flux:link
                :href="route('profile.show', $comment->user->username)"
                variant="subtle"
            >
                {{ $comment->user->name }}
            </flux:link>
            
            &middot; {{ $comment->created_at->diffForHumans() }}
        </flux:text>

        <flux:text>
            {{ $comment->body }}
        </flux:text>
    </flux:card>

    {{-- Parent comment (if any) --}}
    @if ($comment->parent)
        <flux:heading size="lg">
            Replying to
        </flux:heading>

        <flux:card size="sm" class="bg-gray-50">
            <flux:text>
                <flux:link :href="route('profile.show', $comment->parent->user->username)" variant="subtle">
                    {{ $comment->parent->user->name }}
                </flux:link> 
                &middot; {{ $comment->parent->created_at->diffForHumans() }}
            </flux:text>
            <flux:text>
                {{ $comment->parent->body }}
            </flux:text>
        </flux:card>
    @endif

    {{-- Child comments --}}
    @if ($comment->children->isNotEmpty())
        <flux:heading size="lg">
            Who replied
        </flux:heading>
   
        @foreach ($comment->children as $child)
            <flux:card size="sm">
                <flux:text>
                    <flux:link :href="route('profile.show', $child->user->username)" variant="subtle">
                        {{ $child->user->name }}
                    </flux:link>
                    &middot; {{ $child->created_at->diffForHumans() }}
                </flux:text>
                <flux:text>
                    {{ $child->body }}
                </flux:text>
            </flux:card>
        @endforeach
    @endif

</section>