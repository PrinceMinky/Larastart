<flux:navmenu.item 
    href="{{ $notification['url'] }}"
    wire:click="markAsRead('{{ $notification['id'] }}')"
    wire:navigate
    class="relative"
    :key="$notification['id']"
>    
    <div class=" flex items-center space-x-3">
        <flux:avatar :name="$notification['user']['name']" color="auto" size="sm" />

        <div class="flex flex-col gap-0">
            <flux:text>{{ replacePlaceholders($notification['data']['description'], [$notification['data'], 'user' => $notification['user']]) }}</flux:text>
            <flux:text variant="muted" class="text-xs">{{ ($notification['timeAgo'] === "0 seconds ago") ? 'Just Now' : $notification['timeAgo'] }}</flux:text>
        </div>
    </div>

    <x-notifications.dropdown.unread-dot :$notification />
</flux:navmenu.item>