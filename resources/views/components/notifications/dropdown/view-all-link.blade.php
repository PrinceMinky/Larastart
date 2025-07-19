@if(count($processedNotifications) >= $notificationLimit && !$showAllNotifications)
    <flux:separator />
    
    <div class="text-center p-2 cursor-pointer" wire:navigate href="{{ route('notifications.index') }}">
        <flux:text>View all notifications</flux:text>
    </div>
@endif