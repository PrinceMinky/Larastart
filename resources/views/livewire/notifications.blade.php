<section>
    <x-page-heading>
        <x-slot name="heading">Notifications</x-slot>
        <x-slot name="subheading">An overview of your notifications</x-slot>
    </x-page-heading>

    <div class="mt-4 flex flex-col gap-2">
        @if(count($processedNotifications) > 0)
            <div class="mb-4 flex justify-end items-center">                
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <flux:button variant="primary" size="sm" wire:click="markAllAsRead">
                        Mark All as Read
                    </flux:button>
                @endif
            </div>
            
            @foreach ($processedNotifications as $notification)
                <flux:card 
                    :key="$notification['id']" 
                    class="relative {{ !$notification['isRead'] ? 'border-l-4 border-l-primary-500' : '' }}"
                    >
                    <div class="flex items-center space-x-3">
                        <flux:avatar :name="$notification['user']->name" color="auto" size="sm" />

                        <div class="flex flex-col gap-0"
                            href="{{ $notification['url'] }}"
                            wire:click="markAsRead('{{ $notification['id'] }}')"
                            wire:navigate
                        >
                            <flux:text class="cursor-pointer">{{ replacePlaceholders($notification['data']['description'], [$notification['data'], 'user' => $notification['user']]) }}</flux:text>
                            <flux:text variant="muted" class="cursor-pointer text-xs">{{ $notification['timeAgo'] }}</flux:text>
                        </div>
                        
                        <div class="ml-auto flex items-center space-x-2">
                            @if(!$notification['isRead'])
                                <flux:button variant="ghost" size="xs" wire:click="markAsRead('{{ $notification['id'] }}')" icon="check" tooltip="Mark as read" inset="top bottom" square class="cursor-pointer" />
                            @endif

                            <flux:button variant="ghost" size="xs" wire:click="deleteNotification('{{ $notification['id'] }}')" icon="x-circle" tooltip="Delete Notification" inset="top bottom" square class="cursor-pointer" />
                        </div>
                    </div>
                </flux:card>
            @endforeach
            
            <x-infinite-scroll-trigger
                :has-more="$hasMoreNotifications"
                handle="loadMoreNotifications"
                text="Loading notifications."
            />
        @else
            <flux:card>
                <div class="py-4 text-center">
                    <flux:text variant="muted">No notifications yet</flux:text>
                </div>
            </flux:card>
        @endif
    </div>
</section>