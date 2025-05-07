<div>
    <flux:dropdown position="bottom" align="end">
        <flux:navbar.item :badge="$unreadCount" badge-color="green">
                <flux:icon.bell />
        </flux:navbar.item>

        <flux:navmenu class="w-110 max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center p-2">
                <flux:heading>Notifications</flux:heading>

                @if($unreadCount > 0)
                <flux:dropdown position="bottom" align="end">
                    <flux:button square icon="cog" variant="subtle" size="sm" />

                    <flux:menu>
                        <flux:menu.item wire:click="markAllAsRead">Mark as read</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
                @endif
            </div>
            
            @forelse($processedNotifications as $notification)
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
                        <flux:text>{{ replacePlaceholders($notification['data']['action'], [$notification['data'], 'user' => $notification['user']]) }}</flux:text>
                        <flux:text class="text-xs">{{ ($notification['timeAgo'] === "0 seconds ago") ? 'Just Now' : $notification['timeAgo'] }}</flux:text>
                    </div>
                </div>

                @if(! $notification['isRead'])
                <div class="absolute right-0">
                    <span class="flex w-2 h-2 me-2 bg-red-500 rounded-full"></span>
                </div>
                @endif
                </flux:navmenu.item>
            @empty
                <div class="px-4 py-6 text-center">
                    <flux:icon.inbox class="mx-auto" />
                    <flux:text class="mt-2">No notifications yet</flux:text>
                </div>          
            @endforelse
            
            @if(count($processedNotifications) >= $notificationLimit && !$showAllNotifications)
                <flux:navmenu.separator />

                <div class="text-center p-2 cursor-pointer" wire:click="toggleShowAll">
                    <flux:text>View all notifications</flux:text>
                </div>
            @endif
        </flux:navmenu>
    </flux:dropdown>
</div>