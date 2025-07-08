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