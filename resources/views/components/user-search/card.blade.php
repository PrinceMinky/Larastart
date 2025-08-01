<flux:card size="sm" wire:key="{{ $user->id }}" wire:navigate :href="$user->url()"
    class="cursor-pointer transition-shadow hover:shadow-md">
    
    <div class="flex gap-2">
        <flux:avatar :name="$user->name" color="auto" />
        
        <div class="flex flex-col gap-0">
            <flux:heading class="flex gap-0">
                {{ $user->name }}

                @if($user->is_private)
                <flux:icon.lock-closed variant="micro" />
                @endif
            </flux:heading>
            <flux:text>{{ $user->username }}</flux:text>
        </div>
    </div>

    <div>
        <!-- Stats Section Below the Card -->
        <div class="flex gap-4 text-sm text-gray-600 mt-2">            
            <flux:text size="sm" variant="subtle" class="flex flex-col items-start">
                Posts
                <flux:badge size="sm">{{ $user->posts->count() }}</flux:badge>
            </flux:text>

            <flux:text size="sm" variant="subtle" class="flex flex-col items-start">
                Following
                <flux:badge size="sm">{{ $user->following->where('pivot.status', 'accepted')->count() }}</flux:badge>
            </flux:text>
            
            <flux:text size="sm" variant="subtle" class="flex flex-col items-start">
                Followers
                <flux:badge size="sm">{{ $user->followers->where('pivot.status', 'accepted')->count() }}</flux:badge>
            </flux:text>
        </div>
    </div>
</flux:card>