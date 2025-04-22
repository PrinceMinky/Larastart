<div class="flex gap-2">
    <flux:avatar :name="$post->user->name" color="auto" />
    
    <div class="flex flex-col gap-0">
        <flux:heading>
            @if(Route::currentRouteName() !== 'profile.show')
            <flux:link wire:navigate :href="route('profile.show', ['username' => $post->user->username])" variant="ghost" class="!no-underline !hover:no-underline">
                {{ $post->user->name }}
            </flux:link>
            @else
                {{ $post->user->name }}
            @endif
        </flux:heading>
        <flux:text>Posted on {{ $post->created_at->format('M d, Y') }}</flux:text>
    </div>
</div>

<flux:separator />