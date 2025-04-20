<flux:card size="sm" wire:key="{{ $user->id }}" wire:navigate :href="route('profile.show', ['username' => $user->username])"
    class="cursor-pointer transition-shadow hover:shadow-md">
    
    <div class="flex gap-2">
        <flux:avatar :name="$user->name" color="auto" />
        
        <div class="flex flex-col gap-0">
            <flux:heading>{{ $user->name }}</flux:heading>
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
        </div>
    </div>
</flux:card>