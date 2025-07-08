<flux:dropdown position="bottom" align="end">
    <x-notifications.dropdown.button :$unreadCount />

    <flux:popover class="min-w-[30rem] max-h-[30rem] flex flex-col gap-1">
        <x-notifications.dropdown.heading :$unreadCount />
        
        @forelse($processedNotifications as $notification)
            <x-notifications.dropdown.row :$notification />
        @empty
            <x-notifications.dropdown.empty />
        @endforelse
        
        <x-notifications.dropdown.view-all-link :$processedNotifications :$notificationLimit :$showAllNotifications />
    </flux:popover>
</flux:dropdown>